<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarroFoto extends Model
{
    use HasFactory;

    protected $table = 'carro_fotos';

    protected $fillable = [
        'carro_id','url','principal','orden'
    ];

    protected $casts = [
        'principal' => 'boolean',
        'orden' => 'integer',
    ];

    public function carro()
    {
        return $this->belongsTo(Carro::class);
    }
}
