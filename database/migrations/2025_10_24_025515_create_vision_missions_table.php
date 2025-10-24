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
        Schema::create('vision_missions', function (Blueprint $table) {
            $table->id();
            $table->text('vision'); // Visi organisasi
            $table->text('mission'); // Misi organisasi (bisa multiline)
            $table->boolean('is_active')->default(true); // Status aktif
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User yang membuat/update
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vision_missions');
    }
};
