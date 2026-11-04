@extends('layouts.app')

@section('titulo', 'Editar pedido')

@section('conteudo')
    <h1>Editar pedido #{{ $pedido->id_pedido }}</h1>

    <form action="{{ route('pedidos.update', $pedido) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="id_cliente">ID do cliente</label>
        <input type="number" id="id_cliente" name="id_cliente" value="{{ old('id_cliente', $pedido->id_cliente) }}" required>

        <label for="data_pedido">Data do pedido</label>
        <input type="date" id="data_pedido" name="data_pedido" value="{{ old('data_pedido', $pedido->data_pedido) }}" required>

        <label for="valor_frete">Valor do frete (R$)</label>
        <input type="number" step="0.01" min="0" id="valor_frete" name="valor_frete" value="{{ old('valor_frete', $pedido->valor_frete) }}" required>

        <label for="peso_kg">Peso (kg)</label>
        <input type="number" step="0.01" min="0" id="peso_kg" name="peso_kg" value="{{ old('peso_kg', $pedido->peso_kg) }}" required>

        <label for="tipo_carga">Tipo de carga</label>
        <select id="tipo_carga" name="tipo_carga" required>
            @foreach ($tiposCarga as $tipo)
                <option value="{{ $tipo }}" @selected(old('tipo_carga', $pedido->tipo_carga) === $tipo)>{{ $tipo }}</option>
            @endforeach
        </select>

        <label for="prioridade">Prioridade</label>
        <select id="prioridade" name="prioridade" required>
            @foreach ($prioridades as $prioridade)
                <option value="{{ $prioridade }}" @selected(old('prioridade', $pedido->prioridade) === $prioridade)>{{ $prioridade }}</option>
            @endforeach
        </select>

        <label for="status">Status</label>
        <select id="status" name="status" required>
            @foreach ($statusLista as $status)
                <option value="{{ $status }}" @selected(old('status', $pedido->status) === $status)>{{ $status }}</option>
            @endforeach
        </select>

        <div style="margin-top: 20px;" class="acoes">
            <button type="submit" class="btn btn-verde">Atualizar</button>
            <a href="{{ route('pedidos.index') }}" class="btn btn-cinza">Cancelar</a>
        </div>
    </form>
@endsection