<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Paquete;
use App\Models\Servicio;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guia', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Paquete::class);
            $table->integer('almacen_inicio');
            $table->integer('almacen_final');
            $table->date('fecha_recepcion');
            $table->date('fecha_entrega');
            $table->boolean('estado')->default(false);
            $table->foreignIdFor(Servicio::class);
            $table->decimal('precio',8, 2);
            $table->string('codigo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guia');
    }
};
