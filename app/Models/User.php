<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome','data_nasc','peso','altura','tipo_sangue','caminho_foto',  
        'cep','logradouro','numero','bairro','cidade',
        'email','senha',
    ];

    protected $hidden = ['senha'];

    protected $casts = [
        'data_nasc' => 'date',
        'peso'      => 'decimal:2',
        'altura'    => 'decimal:2',
    ];
}
