<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apontamento extends Model
{
    use HasFactory;

    protected $table = 'apontamentos'; // nome da tabela no banco
    protected $primaryKey = 'id_apontamento'; // PK diferente de "id"
    public $timestamps = false; // sua tabela já tem data_criacao, então não precisa de created_at/updated_at

    protected $fillable = [
        'categoria',
        'id_aluno',
        'data_apontamento',
        'horas_trabalhadas',
        'midia',
        'id_subprojeto',
        'descricao',
        'data_criacao'
    ];
}
