<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // Assumes there's at least one user

        if (!$user) {
            $this->command->info('No users found. Please create a user first.');
            return;
        }

        $agendas = [
            [
                'title' => 'Rapat Koordinasi Bulanan',
                'description' => 'Rapat koordinasi bulanan untuk membahas progres kegiatan dinas dan rencana ke depan. Agenda meliputi evaluasi kinerja, pembahasan kendala, dan penyusunan rencana kerja bulan mendatang.',
                'location' => 'Ruang Rapat Utama Dinas PMD',
                'start_date' => Carbon::today()->addDays(7),
                'end_date' => Carbon::today()->addDays(7),
                'start_time' => '09:00:00',
                'end_time' => '12:00:00',
                'status' => 'scheduled',
                'is_active' => true,
            ],
            [
                'title' => 'Sosialisasi Program Pemberdayaan Masyarakat',
                'description' => 'Kegiatan sosialisasi program pemberdayaan masyarakat desa untuk meningkatkan kesadaran dan partisipasi masyarakat dalam pembangunan desa. Target peserta adalah ketua RT/RW dan tokoh masyarakat.',
                'location' => 'Aula Kecamatan',
                'start_date' => Carbon::today()->addDays(14),
                'end_date' => Carbon::today()->addDays(16),
                'start_time' => '08:00:00',
                'end_time' => '17:00:00',
                'status' => 'scheduled',
                'is_active' => true,
            ],
            [
                'title' => 'Pelatihan Keterampilan Masyarakat Desa',
                'description' => 'Program pelatihan keterampilan untuk masyarakat desa dalam bidang pertanian organik, kerajinan tangan, dan pengolahan hasil pertanian. Bertujuan untuk meningkatkan kapasitas dan keterampilan masyarakat.',
                'location' => 'Balai Desa Sumber Makmur',
                'start_date' => Carbon::today()->addDays(21),
                'end_date' => Carbon::today()->addDays(23),
                'start_time' => '08:30:00',
                'end_time' => '16:00:00',
                'status' => 'scheduled',
                'is_active' => true,
            ],
            [
                'title' => 'Evaluasi Program Kerja Triwulan I',
                'description' => 'Evaluasi komprehensif terhadap pelaksanaan program kerja pada triwulan pertama. Meliputi pencapaian target, kendala yang dihadapi, dan rekomendasi perbaikan untuk triwulan berikutnya.',
                'location' => 'Ruang Rapat Dinas PMD',
                'start_date' => Carbon::today()->subDays(5),
                'end_date' => Carbon::today()->subDays(3),
                'start_time' => '13:00:00',
                'end_time' => '17:00:00',
                'status' => 'completed',
                'is_active' => true,
            ],
            [
                'title' => 'Workshop Teknologi Informasi Desa',
                'description' => 'Workshop pemanfaatan teknologi informasi dalam pengelolaan administrasi desa dan pelayanan masyarakat. Peserta adalah perangkat desa dan operator sistem informasi desa.',
                'location' => 'Lab Komputer PEMDA',
                'start_date' => Carbon::today(),
                'end_date' => Carbon::today()->addDays(2),
                'start_time' => '09:00:00',
                'end_time' => '15:00:00',
                'status' => 'ongoing',
                'is_active' => true,
            ],
            [
                'title' => 'Musyawarah Desa (MUSDES) Tahunan',
                'description' => 'Musyawarah desa tahunan untuk membahas Rencana Pembangunan Jangka Menengah Desa (RPJMDes) dan Rencana Kerja Pemerintah Desa (RKPDes). Melibatkan seluruh elemen masyarakat desa.',
                'location' => 'Pendopo Desa Makmur Jaya',
                'start_date' => Carbon::today()->addDays(30),
                'end_date' => Carbon::today()->addDays(30),
                'start_time' => '19:00:00',
                'end_time' => '22:00:00',
                'status' => 'scheduled',
                'is_active' => true,
            ],
            [
                'title' => 'Pembentukan Kelompok Tani Baru',
                'description' => 'Kegiatan pembentukan kelompok tani baru di wilayah yang belum memiliki kelompok tani. Tujuannya untuk mengoptimalkan pengelolaan sumber daya pertanian dan meningkatkan produktivitas.',
                'location' => 'Desa Sumber Tani',
                'start_date' => Carbon::today()->addDays(45),
                'end_date' => Carbon::today()->addDays(45),
                'start_time' => '10:00:00',
                'end_time' => '14:00:00',
                'status' => 'draft',
                'is_active' => false,
            ],
        ];

        foreach ($agendas as $agenda) {
            Agenda::create(array_merge($agenda, [
                'user_id' => $user->id,
                'order_position' => Agenda::max('order_position') + 1,
            ]));
        }

        $this->command->info('Sample agenda data created successfully!');
    }
}
