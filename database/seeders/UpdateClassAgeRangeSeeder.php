<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateClassAgeRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classAgeRanges = [
            'daycare' => '0-2 years',
            'playgroup' => '2-3 years',
            'pp1' => '3-4 years',
            'pp2' => '4-5 years',
            'grade_1' => '6-7 years',
            'grade_2' => '7-8 years',
            'grade_3' => '8-9 years',
            'grade_4' => '9-10 years',
            'grade_5' => '10-11 years',
            'grade_6' => '11-12 years',
        ];

        \App\Models\SchoolClass::all()->each(function ($class) use ($classAgeRanges) {
            if (isset($classAgeRanges[$class->level]) && is_null($class->age_range)) {
                $class->age_range = $classAgeRanges[$class->level];
                $class->save();
            }
        });
    }
}
