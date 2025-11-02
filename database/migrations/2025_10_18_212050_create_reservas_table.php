<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            // FKs
            $table->foreignId('usuario_id')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('sucursal_retiro_id')
                  ->constrained('sucursales')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('sucursal_devolucion_id')
                  ->constrained('sucursales')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            // Fechas y costos
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->decimal('precio_total', 12, 2)->default(0);
            $table->string('estado')->default('pendiente'); // pendiente, confirmada, cancelada, completada

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
