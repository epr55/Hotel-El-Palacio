<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->integer('camas_individual');
            $table->integer('camas_doble');
            $table->bigInteger('precio');
            $table->integer('aseos');
            $table->boolean('balcon')->default(false);
            $table->boolean('escritorio')->default(false);
            $table->boolean('cuna')->default(false);
            $table->string('imagen')->nullable();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('habitaciones');
    }
};

