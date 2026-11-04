@extends('layouts.app')

@section('titulo', 'Pedidos')

@section('conteudo')
    <h1>Pedidos</h1>

    <a href="{{ route('pedidos.create') }}" class="btn btn-verde">Novo pedido</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Data</th>
                <th>Frete</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->id_pedido }}</td>
                    <td>{{ $pedido->cliente?->nome }}</td>
                    <td>{{ $pedido->data_pedido }}</td>
                    <td>R$ {{ number_format($pedido->valor_frete, 2, ',', '.') }}</td>
                    <td>{{ $pedido->status }}</td>
                    <td>
                        <div class="acoes">
                            <a href="{{ route('pedidos.show', $pedido) }}" class="btn">Ver</a>
                            <a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-cinza">Editar</a>
                            <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST" onsubmit="return confirm('Excluir este pedido?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-vermelho">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Nenhum pedido cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="paginacao">
        @if ($pedidos->previousPageUrl())
            <a href="{{ $pedidos->previousPageUrl() }}" class="btn btn-cinza">Anterior</a>
        @endif
        <span>Página {{ $pedidos->currentPage() }} de {{ $pedidos->lastPage() }}</span>
        @if ($pedidos->nextPageUrl())
            <a href="{{ $pedidos->nextPageUrl() }}" class="btn btn-cinza">Próxima</a>
        @endif
    </div>
@endsection