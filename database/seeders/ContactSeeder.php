<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create([
            'email' => 'pemdes@katingan.go.id',
            'phone' => '0812-3456-7890',
            'whatsapp' => '6281234567890',
            'facebook' => 'https://facebook.com/pmdkatingan',
            'instagram' => 'https://instagram.com/pmdkatingan',
            'twitter' => 'https://twitter.com/pmdkatingan',
            'youtube' => 'https://youtube.com/@pmdkatingan',
            'address' => 'Jl. Raya Katingan No. 123, Kasongan, Kalimantan Tengah 74411',
            'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d...',
            'office_hours_open' => '08:00',
            'office_hours_close' => '16:00',
            'office_days' => 'Senin - Jumat',
        ]);
    }
}
