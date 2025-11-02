<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('carro_fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carro_id')
                ->constrained('carros')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('url');               // link absoluto o relativo
            $table->boolean('principal')->default(false);
            $table->unsignedSmallInteger('orden')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carro_fotos');
    }
};

