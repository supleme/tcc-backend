<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function registerStudent(Request $request)
    {
      try {
        $validated = $request->validate([
          'RA' => 'required|string|max:50',
          'nome' => 'required|string|max:255',
          'curso' => 'required|string|max:255',
          'periodo' => 'required|integer',
          'data_nascimento' => 'required|date',
          'endereco' => 'nullable|string|max:255',
          'cidade' => 'nullable|string|max:100',
          'telefone' => 'nullable|string|max:20',
          'email' => 'nullable|email|max:255',
          'CPF' => 'nullable|string|max:14',
          'ativo' => 'boolean',
        ]);

        $aluno = Aluno::create($validated);

        return response()->json([
          'message' => 'Aluno criado com sucesso!',
          'aluno' => $aluno
        ]);

      } catch (\Exception $e) {
          return response()->json([
            'message' => 'Erro ao criar aluno.',
            'error' => $e->getMessage()
          ], 500);
      }
    }
}
