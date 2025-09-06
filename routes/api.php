<?php

use App\Http\Controllers\ApontamentoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Models\Aluno;
use App\Models\Apontamento;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return "Conexão com o banco de dados MySQL funcionando!";
    } catch (\Exception $e) {
        return "Erro de conexão: " . $e->getMessage();
    }
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);

Route::post('/alunos', [StudentController::class, 'registerStudent']);

Route::get('/alunos', function (){
    return Aluno::all();
});

Route::get('/alunos/{id}', function ($id){
    return Aluno::find($id);
});



Route::get('/apontamentos', function () {
    return Apontamento::all();
});

Route::get('/apontamentos/aluno/{id_aluno}', [ApontamentoController::class, 'getByAluno']);


Route::post('/apontamentos', [ApontamentoController::class, 'registerApontamento']);


Route::middleware('auth:api')->group(function () {
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});
?>
