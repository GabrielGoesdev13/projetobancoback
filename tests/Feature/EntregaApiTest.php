<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EntregaApiTest extends TestCase
{
    use RefreshDatabase;

    private function criaDependencias(): void
    {
        DB::table('cliente')->insert([
            'id_cliente' => 1, 'nome' => 'Cliente Teste', 'cpf_cnpj' => '111.111.111-11',
            'email' => 'cliente@teste.com', 'telefone' => '42999999999', 'cidade' => 'Guarapuava',
        ]);
        DB::table('pedido')->insert([
            'id_pedido' => 1, 'id_cliente' => 1, 'data_pedido' => '2026-11-01',
            'valor_frete' => 100, 'peso_kg' => 50, 'tipo_carga' => 'Geral',
            'prioridade' => 'Normal', 'status' => 'Aberto',
        ]);
        DB::table('motorista')->insert([
            'id_motorista' => 1, 'nome' => 'Motorista Teste', 'cpf' => '222.222.222-22',
            'cnh' => '12345678900', 'categoria_cnh' => 'E', 'data_admissao' => '2020-01-01', 'status' => 'Ativo',
        ]);
        DB::table('veiculo')->insert([
            'id_veiculo' => 1, 'placa' => 'ABC1D23', 'modelo' => 'Volvo FH', 'marca' => 'Volvo',
            'tipo' => 'Caminhao', 'ano' => 2020, 'capacidade_kg' => 20000, 'status' => 'Ativo',
        ]);
        DB::table('rota')->insert([
            'id_rota' => 1, 'cidade_origem' => 'Guarapuava', 'cidade_destino' => 'Curitiba',
            'distancia_km' => 250, 'tempo_estimado' => '04:00:00',
        ]);
    }

    public function test_cria_entrega_retorna_201(): void
    {
        $this->criaDependencias();

        $resposta = $this->postJson('/api/entregas', [
            'id_pedido'        => 1,
            'id_motorista'     => 1,
            'id_veiculo'       => 1,
            'id_rota'          => 1,
            'data_saida'       => '2026-11-05',
            'previsao_entrega' => '2026-11-08',
        ]);

        $resposta->assertStatus(201)
                 ->assertJsonPath('data.status', 'Em preparacao');

        $this->assertDatabaseHas('entrega', ['id_pedido' => 1, 'status' => 'Em preparacao']);
    }

    public function test_entrega_invalida_retorna_422(): void
    {
        $resposta = $this->postJson('/api/entregas', [
            'id_pedido' => 999999,
        ]);

        $resposta->assertStatus(422)
                 ->assertJsonValidationErrors(['id_pedido', 'id_motorista', 'id_veiculo', 'id_rota', 'data_saida']);
    }
}
