<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = 'Usuario'; 

    protected $fillable = [
        'name',
        'cpf',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
