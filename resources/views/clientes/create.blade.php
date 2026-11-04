@extends('layouts.app')

@section('titulo', 'Novo cliente')

@section('conteudo')
    <h1>Novo cliente</h1>

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required>

        <label for="cpf_cnpj">CPF/CNPJ</label>
        <input type="text" id="cpf_cnpj" name="cpf_cnpj" value="{{ old('cpf_cnpj') }}" required>

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}">

        <label for="telefone">Telefone</label>
        <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}">

        <label for="cidade">Cidade</label>
        <input type="text" id="cidade" name="cidade" value="{{ old('cidade') }}">

        <div style="margin-top: 20px;" class="acoes">
            <button type="submit" class="btn btn-verde">Salvar</button>
            <a href="{{ route('clientes.index') }}" class="btn btn-cinza">Cancelar</a>
        </div>
    </form>
@endsection