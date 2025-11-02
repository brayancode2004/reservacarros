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

    // MANY-TO-MANY
    public function reservas()
    {
        return $this->belongsToMany(Reserva::class, 'carro_reserva')
            ->withPivot(['tarifa_diaria','dias','subtotal'])
            ->withTimestamps();
    }

    // FOTOS
    public function fotos()
    {
        return $this->hasMany(CarroFoto::class);
    }
}
