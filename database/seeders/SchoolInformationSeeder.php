<?php

namespace Database\Seeders;

use App\Models\SchoolInformation;
use Illuminate\Database\Seeder;

class SchoolInformationSeeder extends Seeder
{
    public function run(): void
    {
        SchoolInformation::firstOrCreate(
            ['name' => 'Sir Isaac Newton School'],
            [
                'name' => 'Sir Isaac Newton School',
                'motto' => 'Creating World Changers.',
                'vision' => 'To be a leading educational institution that nurtures innovative thinkers and global leaders.',
                'mission' => 'To provide quality education that empowers students to excel academically, develop character, and contribute meaningfully to society.',
                'about' => 'Sir Isaac Newton School is a comprehensive educational institution offering programs from Daycare through Grade 6, with specialized programs in French, German, Coding, and Robotics.',
                'email' => 'info@sirisaacnewton.edu',
                'phone' => '+254 700 000 000',
                'phone_secondary' => '+254 700 000 001',
                'address' => 'Nairobi, Kenya',
                'website' => 'https://www.sirisaacnewton.edu',
                'facilities' => [
                    'Modern Classrooms',
                    'Science Laboratories',
                    'Computer Labs',
                    'Library',
                    'Sports Facilities',
                    'Transportation',
                    'Cafeteria',
                    'Playground',
                ],
                'programs' => [
                    'Early Years Education (Daycare, Playgroup, PP1, PP2)',
                    'Primary Education (Grade 1-6)',
                    'French Language Program',
                    'German Language Program',
                    'Coding & Robotics',
                    'Extracurricular Activities',
                ],
                'social_media' => [
                    'facebook' => 'https://facebook.com/sirisaacnewton',
                    'twitter' => 'https://twitter.com/sirisaacnewton',
                    'instagram' => 'https://instagram.com/sirisaacnewton',
                ],
                'status' => 'active',
            ]
        );
    }
}

