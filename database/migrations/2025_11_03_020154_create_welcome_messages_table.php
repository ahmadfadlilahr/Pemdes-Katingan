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
        Schema::create('welcome_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama kepala dinas
            $table->string('position'); // Jabatan
            $table->text('message'); // Kata sambutan
            $table->string('photo')->nullable(); // Foto kepala dinas
            $table->string('signature')->nullable(); // Tanda tangan
            $table->boolean('is_active')->default(false); // Hanya 1 yang aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('welcome_messages');
    }
};
