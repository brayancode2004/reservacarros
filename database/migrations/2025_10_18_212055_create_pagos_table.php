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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reserva_id')
                ->constrained('reservas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete(); // si se borra la reserva, se borran sus pagos

            $table->decimal('monto', 12, 2);
            $table->string('metodo'); // tarjeta, efectivo, transferencia...
            $table->dateTime('fecha_pago')->nullable();
            $table->string('referencia')->nullable(); // nro de transacción
            $table->string('estado')->default('pagado'); // pagado, pendiente, fallido
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
