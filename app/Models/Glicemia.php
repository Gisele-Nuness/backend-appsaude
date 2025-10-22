<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Glicemia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'glicemias';

    protected $fillable = [
        'user_id',
        'valor',
        'observacao',
        'data_glicemia',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'valor' => 'decimal:2',
        'data_glicemia' => 'datetime',
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

