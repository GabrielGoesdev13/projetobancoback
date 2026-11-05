@extends('layouts.app')

@section('titulo', 'Pedido')

@section('conteudo')
    <h1>Pedido #{{ $pedido->id_pedido }}</h1>

    <p><strong>Cliente:</strong> {{ $pedido->cliente?->nome }} (ID {{ $pedido->id_cliente }})</p>
    <p><strong>Data do pedido:</strong> {{ $pedido->data_pedido }}</p>
    <p><strong>Valor do frete:</strong> R$ {{ number_format($pedido->valor_frete, 2, ',', '.') }}</p>
    <p><strong>Peso:</strong> {{ $pedido->peso_kg }} kg</p>
    <p><strong>Tipo de carga:</strong> {{ $pedido->tipo_carga }}</p>
    <p><strong>Prioridade:</strong> {{ $pedido->prioridade }}</p>
    <p><strong>Status:</strong> {{ $pedido->status }}</p>

    <div class="acoes" style="margin-top: 20px;">
        <a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-cinza">Editar</a>
        <a href="{{ route('pedidos.index') }}" class="btn">Voltar</a>
    </div>
@endsection