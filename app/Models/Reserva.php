<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id','carro_id','sucursal_retiro_id','sucursal_devolucion_id',
        'fecha_inicio','fecha_fin','precio_total','estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin'    => 'datetime',
        'precio_total' => 'decimal:2',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function carro()
    {
        return $this->belongsTo(Carro::class);
    }

    public function sucursalRetiro()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_retiro_id');
    }

    public function sucursalDevolucion()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_devolucion_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
