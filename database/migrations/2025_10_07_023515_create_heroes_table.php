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
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image');
            $table->boolean('is_active')->default(true);
            $table->boolean('show_title')->default(true);
            $table->integer('order_position')->default(0);

            // Button 1
            $table->string('button1_text')->nullable();
            $table->string('button1_url')->nullable();
            $table->string('button1_style')->default('primary'); // primary, secondary

            // Button 2
            $table->string('button2_text')->nullable();
            $table->string('button2_url')->nullable();
            $table->string('button2_style')->default('secondary'); // primary, secondary

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};
