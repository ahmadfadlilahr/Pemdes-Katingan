<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please create users first.');
            return;
        }

        $actions = [
            ['action' => 'created', 'description' => 'membuat berita "Pembangunan Infrastruktur Desa Maju"'],
            ['action' => 'updated', 'description' => 'mengupdate agenda "Rapat Koordinasi Kepala Desa"'],
            ['action' => 'deleted', 'description' => 'menghapus galeri "Kegiatan Gotong Royong"'],
            ['action' => 'created', 'description' => 'membuat dokumen "Laporan Keuangan Q1 2025"'],
            ['action' => 'updated', 'description' => 'mengupdate struktur organisasi "Kepala Dinas"'],
            ['action' => 'created', 'description' => 'membuat hero/slider "Selamat Datang di PMD Katingan"'],
            ['action' => 'updated', 'description' => 'mengupdate visi & misi organisasi'],
            ['action' => 'login', 'description' => 'login ke sistem'],
            ['action' => 'created', 'description' => 'membuat agenda "Sosialisasi Program Desa"'],
            ['action' => 'deleted', 'description' => 'menghapus berita "Informasi Lama 2024"'],
            ['action' => 'updated', 'description' => 'mengupdate dokumen "Peraturan Desa Terbaru"'],
            ['action' => 'created', 'description' => 'membuat galeri "Pelatihan UMKM Desa"'],
            ['action' => 'login', 'description' => 'login ke sistem'],
            ['action' => 'updated', 'description' => 'mengupdate berita "Inovasi Desa Digital"'],
            ['action' => 'created', 'description' => 'membuat agenda "Musyawarah Desa 2025"'],
        ];

        $modelTypes = [
            'App\Models\News',
            'App\Models\Agenda',
            'App\Models\Gallery',
            'App\Models\Document',
            'App\Models\Hero',
            'App\Models\VisionMission',
            'App\Models\OrganizationStructure',
            null, // for login
        ];

        $this->command->info('Creating activity logs...');

        foreach ($actions as $index => $data) {
            $user = $users->random();
            $modelType = $data['action'] === 'login' ? null : $modelTypes[array_rand($modelTypes)];

            ActivityLog::create([
                'user_id' => $user->id,
                'action' => $data['action'],
                'description' => $data['description'],
                'model_type' => $modelType,
                'model_id' => $modelType ? rand(1, 5) : null,
                'ip_address' => '127.0.0.' . rand(1, 255),
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'properties' => $data['action'] === 'updated' ? [
                    'old' => ['status' => 'draft'],
                    'new' => ['status' => 'published'],
                ] : null,
                'created_at' => now()->subMinutes(rand(1, 1440)), // Random dalam 24 jam terakhir
            ]);

            $this->command->info("✓ Created: {$data['description']}");
        }

        $this->command->info("Successfully created " . count($actions) . " activity logs.");
    }
}
