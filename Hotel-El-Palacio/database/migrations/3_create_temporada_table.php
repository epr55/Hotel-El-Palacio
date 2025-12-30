<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('temporadas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->float('multiplicador');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_final');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temporadas');
    }
};
