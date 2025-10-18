<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Carro extends Model
{
    use HasFactory;

    protected $fillable = [
        'placa','marca','modelo','anio','tarifa_diaria','estado','sucursal_id'
    ];

    protected $casts = [
        'anio' => 'integer',
        'tarifa_diaria' => 'decimal:2',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
