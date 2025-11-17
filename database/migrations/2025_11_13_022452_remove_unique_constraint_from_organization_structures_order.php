<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Remove unique constraint from order column to allow duplicate orders (horizontal hierarchy).
     */
    public function up(): void
    {
        Schema::table('organization_structures', function (Blueprint $table) {
            // Drop the unique index on 'order' column
            $table->dropUnique('organization_structures_order_unique');
        });
    }

    /**
     * Reverse the migrations.
     * Re-add unique constraint if rolled back.
     */
    public function down(): void
    {
        Schema::table('organization_structures', function (Blueprint $table) {
            // Re-add unique constraint
            $table->unique('order');
        });
    }
};
