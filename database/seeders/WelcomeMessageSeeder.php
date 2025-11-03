<?php

namespace Database\Seeders;

use App\Models\WelcomeMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WelcomeMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WelcomeMessage::create([
            'name' => 'Dr. H. Ahmad Fadli, M.Si',
            'position' => 'Kepala Dinas PMD Kabupaten Katingan',
            'message' => 'Dinas PMD Kabupaten Katingan berkomitmen penuh untuk mewujudkan desa-desa yang mandiri dan sejahtera melalui program pemberdayaan masyarakat yang berkelanjutan dan inovatif.

Kami mengajak seluruh elemen masyarakat untuk bersama-sama membangun desa yang lebih baik, dengan memanfaatkan potensi lokal dan kearifan lokal yang ada.

Mari bersama-sama kita wujudkan desa yang maju, mandiri, dan sejahtera untuk kesejahteraan generasi masa depan.',
            'is_active' => true,
        ]);
    }
}
