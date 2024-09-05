<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';  // Especificar el nombre correcto de la tabla
    
    protected $fillable = [
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'tipo_doc',
        'num_doc',
        'celular',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}