<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function registerStudent(Request $request)
    {
      try {
        $validated = $request->validate([
          'RA' => 'required|string|max:50',
          'name' => 'required|string|max:255',
          'course' => 'required|string|max:255',
          'period' => 'required|integer',
          'birth_date' => 'required|date',
          'address' => 'nullable|string|max:255',
          'city' => 'nullable|string|max:100',
          'telephone' => 'nullable|string|max:20',
          'email' => 'required|email|max:255|unique:alunos,email',
          'password' => 'required|string|min:6',
          'CPF' => 'nullable|string|max:14|unique:alunos,CPF',
          'active' => 'boolean',
          'hours_available' => 'required|integer',
        ]);

        $validated['type'] = 'Student';

        $validated['password'] = Hash::make($validated['password']);

        $aluno = User::create($validated);

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

    public function getStudents(){
        try {
            $students = User::where('type', 'Student')->get();

            if ($students->isEmpty()) {
                return response()->json(['message' => 'Nenhum aluno encontrado.'], 404);
            }
            return response()->json($students, 200);

        }
        catch (\Exception $e) {
        return response()->json([
            'message' => 'Erro ao buscar alunos.',
            'error' => $e->getMessage()
        ], 500);
        }
    }

    public function disableStudent($id){
        try {
            $student = User::where('id_usuario', $id)->first();

            if (!$student) {
                return response()->json(['message' => 'Aluno não encontrado.'], 404);
            }

            if ($student->active == false) {
                return response()->json(['message' => 'Aluno já desativado.'], 400);
            }

            $student->active = false;
            $student->save();

            return response()->json(['message' => 'Aluno desativado com sucesso.'], 200);

        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao desativar aluno.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function enableStudent($id) {
        try {
            $student = User::where('id_usuario', $id)->first();

            if (!$student) {
                return response()->json(['message' => 'Aluno não encontrado.'], 404);
            }

            if ($student->active == true) {
                return response()->json(['message' => 'Aluno já ativo.'], 400);
            }

            $student->active = true;
            $student->save();

            return response()->json(['message' => 'Aluno ativado com sucesso.'], 200);

        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao ativar aluno.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
