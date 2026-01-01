<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            SchoolInformationSeeder::class,
            AboutPageContentSeeder::class,
            TeamMemberSeeder::class,
            HistoryTimelineSeeder::class,
            HomepageSliderSeeder::class,
            HomepageSectionSeeder::class,
            HomepageFeatureSeeder::class,
            HomepageFaqSeeder::class,
            SessionTimeSeeder::class,
            BreadcrumbSeeder::class,
            SchoolClassSeeder::class,
            GalleryImageSeeder::class,
            ContactInformationSeeder::class,
        ]);
    }
}
