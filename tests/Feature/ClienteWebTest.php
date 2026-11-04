<?php

namespace Tests\Feature;

use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteWebTest extends TestCase
{
    use RefreshDatabase;

    public function test_lista_de_clientes_exibe_os_dados_cadastrados(): void
    {
        Cliente::create([
            'nome' => 'Maria Teste',
            'cpf_cnpj' => '111.111.111-11',
            'email' => 'maria@teste.com',
            'telefone' => '42988887777',
            'cidade' => 'Guarapuava',
        ]);

        $response = $this->get('/clientes');

        $response->assertStatus(200);
        $response->assertSee('Maria Teste');
        $response->assertSee('Guarapuava');
    }

    public function test_cadastro_de_cliente_grava_no_banco_e_redireciona(): void
    {
        $response = $this->post('/clientes', [
            'nome' => 'Joao Teste',
            'cpf_cnpj' => '222.222.222-22',
            'email' => 'joao@teste.com',
            'telefone' => '42977776666',
            'cidade' => 'Curitiba',
        ]);

        $response->assertRedirect(route('clientes.index'));
        $this->assertDatabaseHas('cliente', [
            'nome' => 'Joao Teste',
            'email' => 'joao@teste.com',
        ]);
    }
}