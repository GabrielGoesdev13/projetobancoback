@extends('layouts.app')

@section('titulo', 'Cliente')

@section('conteudo')
    <h1>{{ $cliente->nome }}</h1>

    <p><strong>ID:</strong> {{ $cliente->id_cliente }}</p>
    <p><strong>CPF/CNPJ:</strong> {{ $cliente->cpf_cnpj }}</p>
    <p><strong>E-mail:</strong> {{ $cliente->email }}</p>
    <p><strong>Telefone:</strong> {{ $cliente->telefone }}</p>
    <p><strong>Cidade:</strong> {{ $cliente->cidade }}</p>

    <div class="acoes" style="margin-top: 20px;">
        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-cinza">Editar</a>
        <a href="{{ route('clientes.index') }}" class="btn">Voltar</a>
    </div>
@endsection