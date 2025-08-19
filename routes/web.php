<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/teste', function () {
    $teste = [
        'id' => 1,
        'name' => 'Teste',
    ];
    return $teste;
});

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return "Conexão com o banco de dados MySQL funcionando!";
    } catch (\Exception $e) {
        return "Erro de conexão: " . $e->getMessage();
    }
});
?>
