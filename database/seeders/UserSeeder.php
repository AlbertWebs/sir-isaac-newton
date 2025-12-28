<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Get roles (should be created by RolePermissionSeeder first)
        $superAdminRole = Role::where('slug', 'super-admin')->first();
        $adminRole = Role::where('slug', 'admin')->first();
        $cashierRole = Role::where('slug', 'cashier')->first();

        // Create Super Admin user
        if ($superAdminRole) {
            User::firstOrCreate(
                ['email' => 'superadmin@sirisaacnewton.edu'],
                [
                    'name' => 'Super Admin',
                    'password' => Hash::make('password'),
                    'role_id' => $superAdminRole->id,
                ]
            );
        }

        // Create Admin user
        if ($adminRole) {
            User::firstOrCreate(
                ['email' => 'admin@sirisaacnewton.edu'],
                [
                    'name' => 'Administrator',
                    'password' => Hash::make('password'),
                    'role_id' => $adminRole->id,
                ]
            );
        }

        // Create Cashier user
        if ($cashierRole) {
            User::firstOrCreate(
                ['email' => 'cashier@sirisaacnewton.edu'],
                [
                    'name' => 'Cashier',
                    'password' => Hash::make('password'),
                    'role_id' => $cashierRole->id,
                ]
            );
        }
    }
}
