<?php

namespace App\Http\Controllers;

use App\Models\Subproject;
use App\Models\User;
use Illuminate\Http\Request;

class SubprojectController extends Controller
{
    public function registerSubproject(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'status' => 'nullable|integer',
                'link_ref' => 'nullable|string',
            ]);

            $validated['status'] = 1;

            $subproject = Subproject::create($validated);

            return response()->json([
                'message' => 'Subprojeto criado com sucesso!',
                'subproject' => $subproject
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar subprojeto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function assignUser($id, $userId)
    {
        try {
            $subproject = Subproject::findOrFail($id);

            $subproject->users()->syncWithoutDetaching([$userId]);


            return response()->json([
                'message' => 'Usuário atribuido ao subprojeto com sucesso.',
                'subproject' => $subproject,
                'user' => $userId
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atribuir o usuario ao subprojeto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function listSubprojectsByUser($id)
    {
        try {
            $subprojects = Subproject::whereHas('users', function ($query) use ($id) {
                $query->where('users.id_usuario', $id);
            })->get();

            return response()->json([
                'subprojects' => $subprojects
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao listar os subprojetos.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
