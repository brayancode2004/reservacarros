<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carro_reserva', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reserva_id')
                ->constrained('reservas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('carro_id')
                ->constrained('carros')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Snapshot de cada carro dentro de la reserva
            $table->decimal('tarifa_diaria', 10, 2);
            $table->unsignedInteger('dias')->default(1);
            $table->decimal('subtotal', 12, 2);

            $table->timestamps();

            $table->unique(['reserva_id', 'carro_id']); // no repetir mismo carro en la reserva
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carro_reserva');
    }
};
