<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alergia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'alergias';

    protected $fillable = [
        'user_id',
        'nome',
        'tipo',
        'severidade',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFromAuthUser($query)
    {
        return $query->where('user_id', auth()->id());
    }
}
