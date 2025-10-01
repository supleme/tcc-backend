<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apontamento extends Model
{
    use HasFactory;

    protected $table = 'apontamentos';
    protected $primaryKey = 'id_apontamento';
    public $timestamps = false;

    protected $fillable = [
      'categoria',
      'id_usuario',
      'data_apontamento',
      'horas_trabalhadas',
      'midia',
      'id_subprojeto',
      'descricao',
      'data_criacao',
      'tarefa',
      'atividade',
    ];

    public function aluno()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function subproject()
    {
        return $this->belongsTo(Subproject::class, 'id_subprojeto', 'id_subproject');
    }
}
