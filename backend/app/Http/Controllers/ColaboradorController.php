<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColaboradorController extends Controller
{

    public function index()
    {
        return Colaborador::all();
    }

    public function store(Request $request) {

        // Formata o CPF que vem do front-end para sem pontuação e traçõos
        $request->merge([
            'cpf' => preg_replace('/\D/', '', $request->cpf)
        ]);

        $data = $request->all();

        if (!empty($data['data_nascimento'])) {
            $data['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $data['data_nascimento']) -> format('Y-m-d');
        }

        $validator = Validator::make($request->all(), [
            'codigo'        => 'required|unique:colaboradores',
            'nome_completo' => 'required|string',
            'apelido'       => 'nullable|string',
            'nome_pai'      => 'nullable|string',
            'nome_mae'      => 'nullable|string',
            'cpf'           => 'required|string|size:11|unique:colaboradores',
            'data_nascimento' => 'required|string',
            'cargo'           => 'required|string'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $customErrors = [];

            foreach ($errors->messages() as $field => $messages) {
                $value = $request->input($field);
                $customErrors[$field] = match ($field) {
                    'codigo' => "O código “{$value}” já existe.",
                    'cpf'    => "O CPF “{$value}” já existe.",
                    default  => $messages[0],
                };
            }

            return response()->json([
                'id'      => null,
                'dataOperacao'    => now()->toDateTimeString(),
                'metodo'  => $request->method(),
                'mensage' => 'FALHA',
                'errors'  => $customErrors,
            ], 422);
        }

        $colaborador = Colaborador::create($data);

        return response()->json([
            'id' => $colaborador->id,
            'dataOperacao' => $colaborador->created_at->toDateTimeString(),
            'metodo' => 'CRIACAO',
            'retorno' => 'SUCESSO'
        ], 201);
    }


    public function show(string $id) {
        return Colaborador::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $colaborador = Colaborador::findOrFail($id);

        $validated = $request->validate([
            'codigo'          => 'required|unique:colaboradores,codigo,' . $id,
            'nome_completo'   => 'required|string',
            'apelido'         => 'nullable|string',
            'nome_pai'        => 'nullable|string',
            'nome_mae'        => 'nullable|string',
            'cpf'             => 'required|string|size:11|unique:colaboradores,cpf,' . $id,
            'data_nascimento' => 'required|date',
            'cargo'           => 'required|string',
        ]);

        $colaborador->update($validated);

        return response()->json([
            'id'      => $colaborador->id,
            'dataOperacao'    => now()->toDateTimeLocalString(),
            'metodo'  => 'ATUALIZAR',
            'retorno' => 'SUCESSO',
        ], 200);
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
}
