SET search_path TO "Matheus_trabalho_BD", public;

-- trigger 1
CREATE TABLE IF NOT EXISTS log_status_entrega (
    id_log         INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    id_entrega     INTEGER NOT NULL REFERENCES entrega(id_entrega) ON DELETE CASCADE,
    status_antigo  VARCHAR,
    status_novo    VARCHAR,
    data_alteracao TIMESTAMP NOT NULL DEFAULT NOW()
);

-- PROCEDURE 1
CREATE OR REPLACE PROCEDURE sp_finalizar_entrega(p_id_entrega INTEGER)
LANGUAGE plpgsql
AS $$
DECLARE
    v_status VARCHAR;
BEGIN
    SELECT status INTO v_status
    FROM entrega
    WHERE id_entrega = p_id_entrega
    FOR UPDATE;

    IF NOT FOUND THEN
        RAISE EXCEPTION 'Entrega % não encontrada', p_id_entrega;
    END IF;

    IF v_status <> 'Em transito' THEN
        RAISE EXCEPTION 'Só é possível finalizar entregas em trânsito (status atual: %)', v_status;
    END IF;

    UPDATE entrega
    SET status = 'Entregue',
        data_entrega = NOW()
    WHERE id_entrega = p_id_entrega;
END;
$$;

-- PROCEDURE 2
CREATE OR REPLACE PROCEDURE sp_registrar_ocorrencia(
    p_id_entrega INTEGER,
    p_tipo       VARCHAR,
    p_descricao  VARCHAR,
    p_gravidade  VARCHAR
)
LANGUAGE plpgsql
AS $$
BEGIN
    IF NOT EXISTS (SELECT 1 FROM entrega WHERE id_entrega = p_id_entrega) THEN
        RAISE EXCEPTION 'Entrega % não encontrada', p_id_entrega;
    END IF;

    INSERT INTO ocorrencia (id_entrega, tipo, descricao, data_ocorrencia, gravidade, resolvida)
    VALUES (p_id_entrega, p_tipo, p_descricao, NOW(), p_gravidade, FALSE);
END;
$$;

-- TRIGGER 1
CREATE OR REPLACE FUNCTION fn_log_status_entrega()
RETURNS TRIGGER
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO log_status_entrega (id_entrega, status_antigo, status_novo)
    VALUES (OLD.id_entrega, OLD.status, NEW.status);
    RETURN NEW;
END;
$$;

DROP TRIGGER IF EXISTS trg_log_status_entrega ON entrega;
CREATE TRIGGER trg_log_status_entrega
AFTER UPDATE OF status ON entrega
FOR EACH ROW
WHEN (OLD.status IS DISTINCT FROM NEW.status)
EXECUTE FUNCTION fn_log_status_entrega();

-- TRIGGER 2
CREATE OR REPLACE FUNCTION fn_prepara_valida_entrega()
RETURNS TRIGGER
LANGUAGE plpgsql
AS $$
BEGIN
    IF NEW.data_entrega IS NOT NULL AND NEW.data_entrega::date < NEW.data_saida THEN
        RAISE EXCEPTION 'A data de entrega não pode ser anterior à data de saída';
    END IF;

    IF TG_OP = 'INSERT' AND NEW.previsao_entrega IS NOT NULL
       AND NEW.previsao_entrega::date < NEW.data_saida THEN
        RAISE EXCEPTION 'A previsão de entrega não pode ser anterior à data de saída';
    END IF;

    RETURN NEW;
END;
$$;

DROP TRIGGER IF EXISTS trg_prepara_valida_entrega ON entrega;
CREATE TRIGGER trg_prepara_valida_entrega
BEFORE INSERT OR UPDATE OF data_saida, previsao_entrega, data_entrega ON entrega
FOR EACH ROW
EXECUTE FUNCTION fn_prepara_valida_entrega();