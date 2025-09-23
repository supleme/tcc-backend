<?php

use App\Http\Controllers\ApontamentoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubprojectController;
use App\Models\Aluno;
use App\Models\Apontamento;
use App\Models\User;
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

Route::get('/users', function (){
    return User::all();
});


Route::post('/alunos', [StudentController::class, 'registerStudent']);

Route::get('/alunos', [StudentController::class, 'getStudents']);

Route::get('/alunos/{id}', function ($id){
    return Aluno::find($id);
});

Route::get('/apontamentos', function () {
    return Apontamento::all();
});

Route::get('/apontamentos/aluno/{id_aluno}', [ApontamentoController::class, 'getByAluno']);


Route::post('/apontamentos', [ApontamentoController::class, 'registerApontamento']);

Route::post('/subprojects', [SubprojectController::class, 'registerSubproject']);

Route::get('/alunos/report/{category}/{students}', [ApontamentoController::class, 'listNote']);

Route::middleware('auth:api')->group(function () {
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});
?>
