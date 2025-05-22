<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColaboradorController extends Controller {

    public function index() {
        return Colaborador::all();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'codigo' => 'required|unique:colaboradores',
            'nome_completo' => 'required|string',
            'apelido' => 'nullable|string',
            'nome_pai' => 'nullable|string',
            'nome_mae' => 'nullable|string',
            'cpf' => 'required|string|size:11|unique:colaboradores',
            'data_nascimento' => 'required|date',
            'cargo' => 'required|string'
        ]);

        return Colaborador::create($validated);
    }

    public function show(string $id) {
        return Colaborador::findOrFail($id);
    }

    public function update(Request $request, string $id) {
        $colaborador = Colaborador::findOrFail($id);

        $validated = $request -> validate([
            'codigo' => 'required|unique:colaboradores, codigo,'.$id,
            'nome_completo' => 'required|string',
            'apelido' => 'nullable|string',
            'nome_pai' => 'nullable|string',
            'nome_mae' => 'nullable|string',
            'cpf' => 'required|string|size:11|unique|colaboradores, cpf,'.$id,
            'data_nascimento' => 'required|date',
            'cargo' => 'required|string'
        ]);

        $colaborador -> update($validated);

        return $colaborador;
    }

    public function destroy(string $id) {
        $colaborador = Colaborador::findOrFail($id);
        $colaborador -> delete();

        return response() -> json(['mensagem' => 'Colaborador excluído com sucesso.']);
    }
}
