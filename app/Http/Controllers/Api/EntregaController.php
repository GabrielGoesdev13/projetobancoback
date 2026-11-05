<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EntregaResource;
use App\Models\Entrega;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntregaController extends Controller
{
    private const STATUS_INICIAL = 'Em preparacao';


    public function index()
    {
        return EntregaResource::collection(
            Entrega::orderByDesc('id_entrega')->paginate(15)
        );
    }


    public function store(Request $request)
    {
        $dados = $request->validate([
            'id_pedido'        => 'required|integer|exists:pedido,id_pedido',
            'id_motorista'     => 'required|integer|exists:motorista,id_motorista',
            'id_veiculo'       => 'required|integer|exists:veiculo,id_veiculo',
            'id_rota'          => 'required|integer|exists:rota,id_rota',
            'data_saida'       => 'required|date',
            'previsao_entrega' => 'nullable|date|after_or_equal:data_saida',
        ]);

        $dados['status'] = self::STATUS_INICIAL;

        try {
            $entrega = Entrega::create($dados); 
        } catch (QueryException $e) {
            return $this->erroDoBanco($e, 422);
        }

        return (new EntregaResource($entrega))->response()->setStatusCode(201);
    }

  
    public function show(Entrega $entrega)
    {
        return new EntregaResource($entrega);
    }

    
    public function update(Request $request, Entrega $entrega)
    {
        $dados = $request->validate([
            'id_motorista'     => 'sometimes|integer|exists:motorista,id_motorista',
            'id_veiculo'       => 'sometimes|integer|exists:veiculo,id_veiculo',
            'id_rota'          => 'sometimes|integer|exists:rota,id_rota',
            'data_saida'       => 'sometimes|date',
            'previsao_entrega' => 'nullable|date',
        ]);

        try {
            $entrega->update($dados);
        } catch (QueryException $e) {
            return $this->erroDoBanco($e, 422);
        }

        return new EntregaResource($entrega->fresh());
    }

    public function destroy(Entrega $entrega)
    {
        try {
            $entrega->delete();
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Não é possível excluir: a entrega possui ocorrências vinculadas.',
            ], 409);
        }

        return response()->noContent();
    }

    public function finalizar(Entrega $entrega)
    {
        try {
            DB::statement('CALL sp_finalizar_entrega(CAST(? AS integer))', [$entrega->id_entrega]);
        } catch (QueryException $e) {
            return $this->erroDoBanco($e, 422);
        }

        return new EntregaResource($entrega->fresh());
    }

    public function registrarOcorrencia(Request $request, Entrega $entrega): JsonResponse
    {
        $dados = $request->validate([
            'tipo'      => 'required|string|max:100',
            'descricao' => 'required|string|max:255',
            'gravidade' => 'required|string|max:50',
        ]);

        try {
            DB::statement(
                'CALL sp_registrar_ocorrencia(CAST(? AS integer), CAST(? AS varchar), CAST(? AS varchar), CAST(? AS varchar))',
                [$entrega->id_entrega, $dados['tipo'], $dados['descricao'], $dados['gravidade']]
            );
        } catch (QueryException $e) {
            return $this->erroDoBanco($e, 422);
        }

        return response()->json(['message' => 'Ocorrência registrada.'], 201);
    }

    public function historico(Entrega $entrega): JsonResponse
    {
        $historico = DB::table('log_status_entrega')
            ->where('id_entrega', $entrega->id_entrega)
            ->orderBy('data_alteracao')
            ->get();

        return response()->json(['data' => $historico]);
    }

    private function erroDoBanco(QueryException $e, int $status): JsonResponse
    {
        preg_match('/ERROR:\s+(.*?)\s*\(Connection/s', $e->getMessage(), $m);

        return response()->json([
            'message' => $m[1] ?? 'Operação rejeitada pelo banco de dados.',
        ], $status);
    }
}