@extends('layouts.app')

@section('titulo', 'Clientes')

@section('conteudo')
    <h1>Clientes</h1>

    <a href="{{ route('clientes.create') }}" class="btn btn-verde">Novo cliente</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF/CNPJ</th>
                <th>Cidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id_cliente }}</td>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->cpf_cnpj }}</td>
                    <td>{{ $cliente->cidade }}</td>
                    <td>
                        <div class="acoes">
                            <a href="{{ route('clientes.show', $cliente) }}" class="btn">Ver</a>
                            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-cinza">Editar</a>
                            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" onsubmit="return confirm('Excluir este cliente?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-vermelho">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nenhum cliente cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="paginacao">
        @if ($clientes->previousPageUrl())
            <a href="{{ $clientes->previousPageUrl() }}" class="btn btn-cinza">Anterior</a>
        @endif
        <span>Página {{ $clientes->currentPage() }} de {{ $clientes->lastPage() }}</span>
        @if ($clientes->nextPageUrl())
            <a href="{{ $clientes->nextPageUrl() }}" class="btn btn-cinza">Próxima</a>
        @endif
    </div>
@endsection