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
        // Ensure a teacher exists to assign to classes
        $teacher = \App\Models\Teacher::first();
        if (!$teacher) {
            // Create a dummy teacher if none exist
            $teacher = \App\Models\Teacher::create([
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '1234567890',
                'employee_number' => 'EMP001',
                'date_of_birth' => '1980-01-01',
                'gender' => 'Male',
                'address' => '123 Teacher St',
                'status' => 'active',
                'designation' => 'Teacher',
                'hire_date' => '2020-09-01',
            ]);
        }

        $academicYear = '2026';

        // Define class data
        $classes = [
            ['name' => 'Daycare Class A', 'code' => 'DCA', 'level' => 'daycare', 'capacity' => 15, 'price' => 5000],
            ['name' => 'Playgroup Class A', 'code' => 'PGA', 'level' => 'playgroup', 'capacity' => 20, 'price' => 7500],
            ['name' => 'PP1 Class A', 'code' => 'PPA', 'level' => 'pp1', 'capacity' => 25, 'price' => 10000],
            ['name' => 'PP2 Class A', 'code' => 'PPB', 'level' => 'pp2', 'capacity' => 25, 'price' => 12000],
            ['name' => 'Grade 1 Class A', 'code' => 'G1A', 'level' => 'grade_1', 'capacity' => 30, 'price' => 15000],
            ['name' => 'Grade 2 Class A', 'code' => 'G2A', 'level' => 'grade_2', 'capacity' => 30, 'price' => 16000],
            ['name' => 'Grade 3 Class A', 'code' => 'G3A', 'level' => 'grade_3', 'capacity' => 30, 'price' => 17000],
            ['name' => 'Grade 4 Class A', 'code' => 'G4A', 'level' => 'grade_4', 'capacity' => 30, 'price' => 18000],
            ['name' => 'Grade 5 Class A', 'code' => 'G5A', 'level' => 'grade_5', 'capacity' => 30, 'price' => 19000],
            ['name' => 'Grade 6 Class A', 'code' => 'G6A', 'level' => 'grade_6', 'capacity' => 30, 'price' => 20000],
        ];

        foreach ($classes as $classData) {
            \App\Models\SchoolClass::firstOrCreate(
                ['code' => $classData['code']],
                array_merge($classData, [
                    'academic_year' => $academicYear,
                    'term' => 1,
                    'class_teacher_id' => $teacher->id,
                    'status' => 'active',
                    'description' => 'This is the ' . $classData['name'] . ' for academic year ' . $academicYear . ' Term 1.',
                    'current_enrollment' => 0,
                ])
            );
        }
    }
}
