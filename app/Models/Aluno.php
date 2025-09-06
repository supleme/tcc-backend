<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Aluno extends Authenticatable implements JWTSubject
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
        'password',
        'data_nascimento',
        'CPF',
        'ativo'
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
