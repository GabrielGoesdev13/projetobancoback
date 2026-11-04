<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PedidoController extends Controller
{
    private const TIPOS_CARGA = ['Alimentos', 'Eletronicos', 'Pecas automotivas', 'Roupas'];

    private const PRIORIDADES = ['Baixa', 'Normal', 'Alta', 'Urgente'];

    private const STATUS = ['Pendente', 'Em transporte', 'Entregue', 'Cancelado'];

    private function regras(): array
    {
        return [
            'id_cliente' => 'required|integer|exists:cliente,id_cliente',
            'data_pedido' => 'required|date',
            'valor_frete' => 'required|numeric|min:0',
            'peso_kg' => 'required|numeric|min:0',
            'tipo_carga' => ['required', Rule::in(self::TIPOS_CARGA)],
            'prioridade' => ['required', Rule::in(self::PRIORIDADES)],
            'status' => ['required', Rule::in(self::STATUS)],
        ];
    }

    private function opcoes(): array
    {
        return [
            'tiposCarga' => self::TIPOS_CARGA,
            'prioridades' => self::PRIORIDADES,
            'statusLista' => self::STATUS,
        ];
    }

    public function index()
    {
        $pedidos = Pedido::with('cliente')->orderByDesc('id_pedido')->paginate(15);

        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        return view('pedidos.create', $this->opcoes());
    }

    public function store(Request $request)
    {
        $dados = $request->validate($this->regras());

        Pedido::create($dados);

        return redirect()->route('pedidos.index')->with('sucesso', 'Pedido cadastrado com sucesso.');
    }

    public function show(Pedido $pedido)
    {
        $pedido->load('cliente');

        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        return view('pedidos.edit', array_merge(['pedido' => $pedido], $this->opcoes()));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $dados = $request->validate($this->regras());

        $pedido->update($dados);

        return redirect()->route('pedidos.index')->with('sucesso', 'Pedido atualizado com sucesso.');
    }

    public function destroy(Pedido $pedido)
    {
        try {
            $pedido->delete();
        } catch (QueryException $e) {
            return redirect()->route('pedidos.index')->withErrors([
                'exclusao' => 'Não foi possível excluir: este pedido tem pagamentos ou entregas ligados a ele.',
            ]);
        }

        return redirect()->route('pedidos.index')->with('sucesso', 'Pedido excluído com sucesso.');
    }
}