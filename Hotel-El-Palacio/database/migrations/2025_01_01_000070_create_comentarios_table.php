<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->enum('valoracion', ['1','2','3','4','5']);
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha');

            $table->foreignId('usuario_id')
                  ->constrained('usuarios')
                  ->onDelete('cascade');

            $table->foreignId('habitacion_id')
                  ->constrained('habitaciones')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
