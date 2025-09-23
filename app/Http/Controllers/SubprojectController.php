<?php

namespace App\Http\Controllers;

use App\Models\Subproject;
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
}
