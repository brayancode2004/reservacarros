<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursales';

    protected $fillable = ['nombre','direccion','ciudad','pais'];

    public function carros()
    {
        return $this->hasMany(Carro::class);
    }

    public function reservasRetiro()
    {
        return $this->hasMany(Reserva::class, 'sucursal_retiro_id');
    }

    public function reservasDevolucion()
    {
        return $this->hasMany(Reserva::class, 'sucursal_devolucion_id');
    }
}
