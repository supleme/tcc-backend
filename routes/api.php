<?php

use App\Http\Controllers\StudentController;
use App\Models\Aluno;
use Illuminate\Support\Facades\Route;

Route::get('/alunos', function (){
    return Aluno::all();
});

Route::get('/alunos/{id}', function ($id){
    return Aluno::find($id);
});


Route::post('/alunos', [StudentController::class, 'registerStudent']);

?>
