<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Club::firstOrCreate(
            ['name' => 'Chess Club'],
            ['code' => 'CHESS', 'description' => 'A club for chess enthusiasts to learn and play.']
        );

        \App\Models\Club::firstOrCreate(
            ['name' => 'Music Club'],
            ['code' => 'MUSIC', 'description' => 'Explore various musical instruments and vocal training.']
        );

        \App\Models\Club::firstOrCreate(
            ['name' => 'Skating Club'],
            ['code' => 'SKATE', 'description' => 'Learn and enjoy roller skating and ice skating.']
        );

        \App\Models\Club::firstOrCreate(
            ['name' => 'Drama Club'],
            ['code' => 'DRAMA', 'description' => 'Develop acting skills and perform plays.']
        );

        \App\Models\Club::firstOrCreate(
            ['name' => 'Swimming Club'],
            ['code' => 'SWIM', 'description' => 'Improve swimming techniques and compete.']
        );

        \App\Models\Club::firstOrCreate(
            ['name' => 'Art Club'],
            ['code' => 'ART', 'description' => 'Express creativity through various art forms.']
        );

        \App\Models\Club::firstOrCreate(
            ['name' => 'Debate Club'],
            ['code' => 'DEBATE', 'description' => 'Enhance public speaking and argumentation skills.']
        );
    }
}
