<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subproject extends Model
{
    use HasFactory;

    protected $table = 'subprojects';
    protected $primaryKey = 'id_subproject';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'link_ref',
    ];
}
