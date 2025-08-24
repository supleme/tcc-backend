<?php

namespace App\Http\Controllers;

use App\Models\Apontamento;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApontamentoController extends Controller
{
    public function registerApontamento(Request $request)
    {
      try {
        $validated = $request->validate([
          'categoria' => 'required|string|in:Atividade,Subprojeto',
          'id_aluno' => 'required|integer|exists:alunos,id_aluno',
          'data_apontamento' => 'required|date',
          'horas_trabalhadas' => 'required|numeric|min:0',
          'midia' => 'nullable|string|max:255',
        //   'id_subprojeto' => 'required|integer',
          'descricao' => 'nullable|string',
        ]);

        $validated['data_criacao'] = Carbon::now();
        $validated['categoria'] = ucfirst(strtolower($validated['categoria']));

        $apontamento = Apontamento::create($validated);

        return response()->json([
          'message' => 'Apontamento criado com sucesso!',
          'apontamento' => $apontamento
        ], 201);

      } catch (\Exception $e) {
          return response()->json([
            'message' => 'Erro ao criar apontamento.',
            'error' => $e->getMessage()
          ], 500);
      }
    }

  public function listNote(){
    try {
      $apontamentos = Apontamento::all();
      return response()->json($apontamentos, 200);
    } catch (\Exception $e) {
        return response()->json([
          'message' => 'Erro ao listar apontamentos.',
          'error' => $e->getMessage()
        ], 500);
    }
  }
}
