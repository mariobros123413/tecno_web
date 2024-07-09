<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Guia;
use App\Models\Almacen;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ruta_rastreo', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Guia::class);
            $table->foreignIdFor(Almacen::class);
            $table->date('fecha_registro');
            $table->boolean('estado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruta_rastreo');
    }
};
