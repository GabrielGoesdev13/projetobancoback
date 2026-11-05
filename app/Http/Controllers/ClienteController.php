<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::orderByDesc('id_cliente')->paginate(15);

        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:100',
            'cpf_cnpj' => 'required|string|max:18',
            'email' => 'required|email|max:100',
            'telefone' => 'required|string|max:20',
            'cidade' => 'required|string|max:100',
        ]);

        Cliente::create($dados);

        return redirect()->route('clientes.index')->with('sucesso', 'Cliente cadastrado com sucesso.');
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:100',
            'cpf_cnpj' => 'required|string|max:18',
            'email' => 'required|email|max:100',
            'telefone' => 'required|string|max:20',
            'cidade' => 'required|string|max:100',
        ]);

        $cliente->update($dados);

        return redirect()->route('clientes.index')->with('sucesso', 'Cliente atualizado com sucesso.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')->with('sucesso', 'Cliente excluído com sucesso.');
    }
}