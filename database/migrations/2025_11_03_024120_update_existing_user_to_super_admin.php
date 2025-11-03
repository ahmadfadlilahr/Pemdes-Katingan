<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing user to super admin
        $user = User::where('email', 'audentkent@gmail.com')->first();
        if ($user) {
            $user->update([
                'role' => 'super-admin',
                'is_active' => true
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally revert back to admin
        $user = User::where('email', 'audentkent@gmail.com')->first();
        if ($user) {
            $user->update([
                'role' => 'admin'
            ]);
        }
    }
};
