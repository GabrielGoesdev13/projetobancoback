@extends('layouts.app')

@section('titulo', 'Editar cliente')

@section('conteudo')
    <h1>Editar cliente</h1>

    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" value="{{ old('nome', $cliente->nome) }}" required>

        <label for="cpf_cnpj">CPF/CNPJ</label>
        <input type="text" id="cpf_cnpj" name="cpf_cnpj" value="{{ old('cpf_cnpj', $cliente->cpf_cnpj) }}" required>

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" value="{{ old('email', $cliente->email) }}" required>

        <label for="telefone">Telefone</label>
        <input type="text" id="telefone" name="telefone" value="{{ old('telefone', $cliente->telefone) }}" required>

        <label for="cidade">Cidade</label>
        <input type="text" id="cidade" name="cidade" value="{{ old('cidade', $cliente->cidade) }}" required>

        <div style="margin-top: 20px;" class="acoes">
            <button type="submit" class="btn btn-verde">Atualizar</button>
            <a href="{{ route('clientes.index') }}" class="btn btn-cinza">Cancelar</a>
        </div>
    </form>
@endsection