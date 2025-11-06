<?php

namespace App\Http\Controllers;

use App\Models\Apontamento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApontamentoController extends Controller
{
    public function registerApontamento(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
            'atividade' => 'nullable|string|max:255',
            'categoria' => 'required|string|in:Atividade,Subprojeto',
            'data_apontamento' => 'required|date',
            'descricao' => 'nullable|string',
            'horas_trabalhadas' => 'required|numeric|min:0',
            'id_subprojeto' => 'nullable|integer',
            'id_usuario' => 'required|integer|integer',
            'midia' => 'nullable|file|max:10240',
            'tarefa' => 'nullable|string|max:255'
            ]);

            $caminho_midia = null;
            if ($request->hasFile('midia')) {
                $file = $request->file('midia');
                $caminho_midia = $file->store('apontamentos', 'public');
            }

            $validated['midia'] = $caminho_midia;
            $validated['data_criacao'] = Carbon::now();
            $validated['categoria'] = ucfirst(strtolower($validated['categoria']));

            $apontamento = Apontamento::create($validated);

            DB::commit();

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

  public function listNote($category, $student, $month, $year) {
    try {
      $query = Apontamento::query();

      $query->with(['aluno' => function($q) {
        $q->select('id_usuario', 'name');
      }]);

      if($category !== 'Todas'){
        $query->where('categoria', $category);
      }

      if($student !== 'Todos'){
        $studentArray = explode(',', $student);
        $query->whereIn('id_usuario', $studentArray);
      }
    //   $year = now()->year;

      if($month !== 'Todos'){
          $query->whereYear('data_apontamento', $year)
                ->whereMonth('data_apontamento', $month);
      } else {
          $query->whereYear('data_apontamento', $year);
      }

      $apontamentos = $query->get();

      $apontamentos = $apontamentos->map(function ($apontamento) {
        $apontamento->aluno_nome = $apontamento->aluno->name;
        unset($apontamento->aluno);
        return $apontamento;
      });

      if ($apontamentos->isEmpty()) {
        return response()->json(['message' => 'Nenhum apontamento encontrado para este aluno.'], 204);
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
        DB::statement("SET lc_time_names = 'PT_BR'");

        $summaryMonthly = Apontamento::select(
                DB::raw("DATE_FORMAT(data_apontamento, '%M/%Y') as mes"),
                DB::raw('SUM(horas_trabalhadas) as horas_trabalhadas')
            )
            ->where('id_usuario', $id_aluno)
            ->groupBy(DB::raw("DATE_FORMAT(data_apontamento, '%M/%Y')"))
            ->orderBy('mes', 'desc')
            ->get();

        $summaryMonthly->transform(function ($item) {
             $dateParts = explode('/', $item->mes);
             $item->mes = ucfirst($dateParts[0]) . '/' . $dateParts[1];
             return $item;
        });

        $apontamentos = Apontamento::with('subproject')
            ->where('id_usuario', $id_aluno)
            ->get();

        if ($summaryMonthly->isEmpty() && $apontamentos->isEmpty()) {
            return response()->json(['message' => 'Nenhum apontamento encontrado para este aluno.'], 404);
        }

        return response()->json([
            'summaryMonthly' => $summaryMonthly, // Para o resumo de horas
            'apontamentos' => $apontamentos, // Para a lista detalhada
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Erro ao buscar apontamentos.',
            'error' => $e->getMessage()
        ], 500);
    }
  }

  public function deleteApontamento($id) {
    $apontamento = Apontamento::find($id);

    if (!$apontamento) {
        return response()->json([
            'message' => 'Apontamento nao encontrado.',
        ], 404);
    }

    $apontamento->delete();

    return response()->json([
        'message' => 'Apontamento deletado com sucesso.',
        'apontamento' => $apontamento
    ], 200);
  }

  public function updateApontamento(Request $request) {
    $validated = $request->validate([
        'id_apontamento' => 'required|integer',
        'horas_trabalhadas' => 'required|integer',
        'data_apontamento' => 'required|date',
    ]);

    $apontamento = Apontamento::find($validated['id_apontamento']);

    if (!$apontamento) {
        return response()->json([
            'message' => 'Apontamento não encontrado.'
        ], 404);
    }

    $apontamento->horas_trabalhadas = $validated['horas_trabalhadas'];
    $apontamento->data_apontamento = $validated['data_apontamento'];
    $apontamento->save();

    return response()->json([
        'message' => 'Horas atualizadas com sucesso!',
        'apontamento' => $apontamento
    ], 200);
  }
}
