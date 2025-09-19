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
          'id_aluno' => 'required|integer|integer',
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

  public function listNote($category, $student){
    //dd($category, $student);
    try {
      $query = Apontamento::query();

      $query->with(['aluno' => function($q) {
        $q->select('id_aluno', 'nome');
      }]);

      if($category !== 'Todas'){
        $query->where('categoria', $category);
      }

      if($student !== 'Todos'){
        $query->where('id_aluno', $student);
        $studentArray = explode(',', $student);
        $query->whereIn('id_aluno', $studentArray);
      }
      $apontamentos = $query->get();

      $apontamentos = $apontamentos->map(function ($apontamento) {
        $apontamento->aluno_nome = $apontamento->aluno->nome;
        unset($apontamento->aluno); // Remove a relação para simplificar o JSON
        return $apontamento;
      });

      if ($apontamentos->isEmpty()) {
        return response()->json(['message' => 'Nenhum apontamento encontrado para este aluno.'], 404);
      }
      return response()->json($apontamentos, 200);
    } catch (\Exception $e) {
        return response()->json([
          'message' => 'Erro ao listar apontamentos.',
          'error' => $e->getMessage()
        ], 500);
    }
  }

  public function getByAluno($id_aluno)
  {
    try {
      $apontamentos = Apontamento::where('id_aluno', $id_aluno)->get();

      if ($apontamentos->isEmpty()) {
        return response()->json(['message' => 'Nenhum apontamento encontrado para este aluno.'], 404);
      }
      return response()->json($apontamentos, 200);

    }
    catch (\Exception $e) {
      return response()->json([
        'message' => 'Erro ao buscar apontamentos.',
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
