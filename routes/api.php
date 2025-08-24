<?php

use App\Http\Controllers\ApontamentoController;
use App\Http\Controllers\StudentController;
use App\Models\Aluno;
use App\Models\Apontamento;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/alunos', function (){
    return Aluno::all();
});

Route::get('/alunos/{id}', function ($id){
    return Aluno::find($id);
});

Route::post('/alunos', [StudentController::class, 'registerStudent']);

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return "Conexão com o banco de dados MySQL funcionando!";
    } catch (\Exception $e) {
        return "Erro de conexão: " . $e->getMessage();
    }
});

Route::get('/apontamentos', function () {
    return Apontamento::all();
});

Route::post('/apontamentos', [ApontamentoController::class, 'registerApontamento']);
?>
