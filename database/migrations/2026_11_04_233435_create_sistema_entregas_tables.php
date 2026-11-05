<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('cliente')) {
            Schema::create('cliente', function (Blueprint $table) {
                $table->increments('id_cliente');
                $table->string('nome', 100);
                $table->string('cpf_cnpj', 18);
                $table->string('email', 100);
                $table->string('telefone', 20);
                $table->string('cidade', 100);
            });
        }

        if (! Schema::hasTable('motorista')) {
            Schema::create('motorista', function (Blueprint $table) {
                $table->increments('id_motorista');
                $table->string('nome', 100);
                $table->string('cpf', 14);
                $table->string('cnh', 20);
                $table->string('categoria_cnh', 5);
                $table->date('data_admissao');
                $table->string('status', 30);
            });
        }

        if (! Schema::hasTable('veiculo')) {
            Schema::create('veiculo', function (Blueprint $table) {
                $table->increments('id_veiculo');
                $table->string('placa', 10);
                $table->string('modelo', 50);
                $table->string('marca', 50);
                $table->string('tipo', 30);
                $table->integer('ano');
                $table->decimal('capacidade_kg', 10, 2);
                $table->string('status', 30);
            });
        }

        if (! Schema::hasTable('rota')) {
            Schema::create('rota', function (Blueprint $table) {
                $table->increments('id_rota');
                $table->string('cidade_origem', 100);
                $table->string('cidade_destino', 100);
                $table->decimal('distancia_km', 10, 2);
                $table->string('tempo_estimado', 30);
            });
        }

        if (! Schema::hasTable('pedido')) {
            Schema::create('pedido', function (Blueprint $table) {
                $table->increments('id_pedido');
                $table->unsignedInteger('id_cliente');
                $table->date('data_pedido');
                $table->decimal('valor_frete', 10, 2);
                $table->decimal('peso_kg', 10, 2);
                $table->string('tipo_carga', 50);
                $table->string('prioridade', 30);
                $table->string('status', 30);

                $table->foreign('id_cliente')->references('id_cliente')->on('cliente');
            });
        }

        if (! Schema::hasTable('pagamento')) {
            Schema::create('pagamento', function (Blueprint $table) {
                $table->increments('id_pagamento');
                $table->unsignedInteger('id_pedido');
                $table->decimal('valor', 10, 2);
                $table->date('data_pagamento')->nullable();
                $table->string('metodo', 30);
                $table->string('status', 30);

                $table->foreign('id_pedido')->references('id_pedido')->on('pedido');
            });
        }

        if (! Schema::hasTable('entrega')) {
            Schema::create('entrega', function (Blueprint $table) {
                $table->increments('id_entrega');
                $table->unsignedInteger('id_pedido');
                $table->unsignedInteger('id_motorista');
                $table->unsignedInteger('id_veiculo');
                $table->unsignedInteger('id_rota');
                $table->date('data_saida')->nullable();
                $table->timestamp('previsao_entrega')->nullable();
                $table->timestamp('data_entrega')->nullable();
                $table->string('status', 30);

                $table->foreign('id_pedido')->references('id_pedido')->on('pedido');
                $table->foreign('id_motorista')->references('id_motorista')->on('motorista');
                $table->foreign('id_veiculo')->references('id_veiculo')->on('veiculo');
                $table->foreign('id_rota')->references('id_rota')->on('rota');
            });
        }

        if (! Schema::hasTable('log_status_entrega')) {
            Schema::create('log_status_entrega', function (Blueprint $table) {
                $table->increments('id_log');
                $table->unsignedInteger('id_entrega');
                $table->string('status_antigo', 30)->nullable();
                $table->string('status_novo', 30);
                $table->timestamp('data_alteracao')->nullable();

                $table->foreign('id_entrega')->references('id_entrega')->on('entrega');
            });
        }

        if (! Schema::hasTable('ocorrencia')) {
            Schema::create('ocorrencia', function (Blueprint $table) {
                $table->increments('id_ocorrencia');
                $table->unsignedInteger('id_entrega');
                $table->string('tipo', 50);
                $table->string('descricao', 255);
                $table->timestamp('data_ocorrencia')->nullable();
                $table->string('gravidade', 30);
                $table->boolean('resolvida')->default(false);

                $table->foreign('id_entrega')->references('id_entrega')->on('entrega');
            });
        }
    }

    public function down(): void
    {
    }
};