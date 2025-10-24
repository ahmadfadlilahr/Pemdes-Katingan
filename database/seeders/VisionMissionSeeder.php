<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisionMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\VisionMission::create([
            'vision' => 'Menjadi dinas yang profesional, inovatif, dan terpercaya dalam pembangunan dan pemberdayaan masyarakat desa untuk mewujudkan desa yang mandiri, maju, dan sejahtera.',
            'mission' => "1. Meningkatkan kapasitas dan kompetensi aparatur pemerintahan desa dalam penyelenggaraan pemerintahan yang baik dan benar.\n\n2. Mengoptimalkan pembangunan infrastruktur dan fasilitas desa yang berkualitas dan berkelanjutan.\n\n3. Memberdayakan masyarakat desa melalui program-program pembangunan ekonomi, sosial, dan budaya.\n\n4. Meningkatkan partisipasi dan peran serta masyarakat dalam perencanaan dan pelaksanaan pembangunan desa.\n\n5. Memperkuat sistem pengawasan dan evaluasi terhadap pelaksanaan program pembangunan dan pemberdayaan masyarakat desa.",
            'is_active' => true,
            'user_id' => 1, // Assuming user with ID 1 exists
        ]);

        \App\Models\VisionMission::create([
            'vision' => 'Terwujudnya desa yang mandiri, sejahtera, dan berkeadilan melalui pemberdayaan masyarakat dan pembangunan berkelanjutan.',
            'mission' => "1. Meningkatkan kualitas pelayanan publik di tingkat desa.\n\n2. Mengembangkan potensi ekonomi lokal desa melalui usaha mikro, kecil, dan menengah.\n\n3. Meningkatkan kualitas sumber daya manusia melalui pendidikan dan pelatihan.\n\n4. Melestarikan nilai-nilai budaya dan kearifan lokal desa.\n\n5. Meningkatkan kesejahteraan masyarakat melalui program-program pemberdayaan yang tepat sasaran.",
            'is_active' => false,
            'user_id' => 1,
        ]);
    }
}
