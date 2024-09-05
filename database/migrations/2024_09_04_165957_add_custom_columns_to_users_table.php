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
        Schema::table('users', function (Blueprint $table) {
            $table->string('codigo_trabajador')->unique()->after('id');
            $table->string('telefono')->after('email');
            $table->string('puesto')->after('telefono');
            $table->enum('rol', ['Encargado', 'Vendedor', 'Delivery', 'Repartidor'])->after('puesto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['codigo_trabajador', 'telefono', 'puesto', 'rol']);
        });
    }
};
