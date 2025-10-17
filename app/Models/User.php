<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'data_nasc',
        'peso',
        'altura',
        'tipo_sangue',
        'caminho_foto',
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'cidade',
        'email',
        'senha',
    ];

    protected $hidden = ['senha', 'remember_token'];

    protected $casts = [
        'data_nasc' => 'date',
        'peso'      => 'decimal:2',
        'altura'    => 'decimal:2',
    ];

    public function alergias()
    {

        return $this->hasMany(\App\Models\Alergia::class, 'user_id', 'id');
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }
}
