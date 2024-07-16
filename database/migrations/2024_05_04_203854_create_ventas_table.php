<?php

use App\Models\Guia;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('venta', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('fecha');
            $table->decimal('monto_total', 8, 2);
            $table->integer('estado');
            $table->text('image_qr');
            $table->foreignIdFor(Guia::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta');
    }
};
