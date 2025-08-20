<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $table = 'alunos';
    protected $primaryKey = 'id_aluno';

    protected $fillable = [
        'RA',
        'nome',
        'curso',
        'periodo',
        'endereco',
        'cidade',
        'telefone',
        'email',
        'data_nascimento',
        'CPF',
        'ativo'
    ];
}
