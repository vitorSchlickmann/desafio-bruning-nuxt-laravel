<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ColaboradorController extends Controller {

    public function index() {
        return Colaborador::all();
    }

    public function store(Request $request) {
        try {
            $validated = $request->validate([
                'codigo'          => 'required|unique:colaboradores,codigo',
                'nome_completo'   => 'required|string',
                'cpf'             => 'required|string|size:11|unique:colaboradores,cpf',
                'data_nascimento' => 'required|date',
                'cargo'           => 'required|string',
                'apelido'         => 'nullable|string',
                'nome_pai'        => 'nullable|string',
                'nome_mae'        => 'nullable|string',
            ]);

            Colaborador::create($validated);

            return response()->json([
                'retorno' => 'SUCESSO',
                'mensagem' => 'Colaborador criado com sucesso!',
            ], 201);
        } catch (\Throwable $e) {
            Log::error('❌ ERRO AO CADASTRAR', [
                'erro' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile()
            ]);

            return response()->json([
                'erro' => 'Erro interno no servidor',
                'detalhe' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id) {
        return Colaborador::findOrFail($id);
    }

    public function update(Request $request, $id) {
    try {
        $colaborador = Colaborador::findOrFail($id);

        $validated = $request->validate([
            'codigo' => [
                'required',
                Rule::unique('colaboradores', 'codigo')->ignore($id),
            ],
            'nome_completo'   => 'required|string',
            'apelido'         => 'nullable|string',
            'nome_pai'        => 'nullable|string',
            'nome_mae'        => 'nullable|string',
            'cpf' => [
                'required',
                'string',
                'size:11',
                Rule::unique('colaboradores', 'cpf')->ignore($id),
            ],
            'data_nascimento' => 'required|date',
            'cargo'           => 'required|string',
        ]);

        $colaborador->update($validated);

        return response()->json([
            'id'           => $colaborador->id,
            'dataOperacao' => now()->toDateTimeLocalString(),
            'metodo'       => 'ATUALIZAR',
            'retorno'      => 'SUCESSO',
        ], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => 'Dados inválidos',
            'errors'  => $e->errors(),
        ], 422);
    } catch (\Throwable $e) {
        return response()->json([
            'erro'    => 'Erro interno ao atualizar colaborador',
            'detalhe' => $e->getMessage(),
        ], 500);
    }
}

    public function destroy(string $id) {
        $colaborador = Colaborador::find($id);

        if (!$colaborador) {
            return response()->json([
                'id' => null,
                'dataOperacao' => now()->toDateTimeString(),
                'metodo' => 'EXCLUSAO',
                'retorno' => 'NAO_ENCONTRADO',
                'mensage' => 'Colaborador não encontrado'
            ], 404);
        }

        $colaborador->delete();

        return response()->json([
            'id'      => $id,
            'dataOperacao'    => now()->toDateTimeString(),
            'metodo'  => 'EXCLUSAO',
            'retorno' => 'SUCESSO',
            'mensage' => "Colaborador ({$colaborador->id} - {$colaborador->nome_completo}) excluído com sucesso."
        ], 200);
    }

    public function proximoCodigo() {
        $ultimoColaborador = Colaborador::orderBy('codigo', 'desc')->first();
        $proximoCodigo = $ultimoColaborador ? $ultimoColaborador->codigo + 1 : 1;

        return response()->json(['proximo_codigo' => $proximoCodigo]);
    }
}
