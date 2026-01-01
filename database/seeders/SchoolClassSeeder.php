<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            [
                "name" => "Daycare",
                "code" => "DC",
                "level" => "daycare",
                "academic_year" => "2025/2026",
                "age_range" => "0-2 years",
                "description" => "Focuses on sensory exploration, early language development, and foundational social-emotional skills in a nurturing environment."
            ],
            [
                "name" => "Playgroup",
                "code" => "PG",
                "level" => "playgroup",
                "academic_year" => "2025/2026",
                "age_range" => "2-3 years",
                "description" => "Encourages imaginative play, basic communication, and motor skill development through interactive and child-led activities."
            ],
            [
                "name" => "PP1",
                "code" => "P1",
                "level" => "pp1",
                "academic_year" => "2025/2026",
                "age_range" => "3-4 years",
                "description" => "Builds early literacy and numeracy skills through play-based learning, fostering curiosity and social interaction."
            ],
            [
                "name" => "PP2",
                "code" => "P2",
                "level" => "pp2",
                "academic_year" => "2025/2026",
                "age_range" => "4-5 years",
                "description" => "Prepares learners for Grade 1 by enhancing foundational competencies, problem-solving, and creative expression through engaging experiences."
            ],
            [
                "name" => "Grade 1",
                "code" => "G1",
                "level" => "grade_1",
                "academic_year" => "2025/2026",
                "age_range" => "6-7 years",
                "description" => "Introduces formal learning in literacy and numeracy, promoting critical thinking and collaborative skills through experiential activities."
            ],
            [
                "name" => "Grade 2",
                "code" => "G2",
                "level" => "grade_2",
                "academic_year" => "2025/2026",
                "age_range" => "7-8 years",
                "description" => "Expands on foundational skills with increased emphasis on practical application, inquiry-based learning, and character development."
            ],
            [
                "name" => "Grade 3",
                "code" => "G3",
                "level" => "grade_3",
                "academic_year" => "2025/2026",
                "age_range" => "8-9 years",
                "description" => "Develops higher-order thinking, creativity, and communication, integrating digital literacy and environmental awareness into learning."
            ],
            [
                "name" => "Grade 4",
                "code" => "G4",
                "level" => "grade_4",
                "academic_year" => "2025/2026",
                "age_range" => "9-10 years",
                "description" => "Fosters deeper understanding of concepts across various learning areas, encouraging independent research and community engagement."
            ],
            [
                "name" => "Grade 5",
                "code" => "G5",
                "level" => "grade_5",
                "academic_year" => "2025/2026",
                "age_range" => "10-11 years",
                "description" => "Strengthens competency in diverse subjects, emphasizing innovation, leadership, and ethical reasoning through project-based learning."
            ],
            [
                "name" => "Grade 6",
                "code" => "G6",
                "level" => "grade_6",
                "academic_year" => "2025/2026",
                "age_range" => "11-12 years",
                "description" => "Prepares learners for junior secondary by consolidating CBC competencies, promoting self-efficacy and active participation in society."
            ]
        ];

        foreach ($classes as $classData) {
            \App\Models\SchoolClass::create($classData);
        }
    }
}
