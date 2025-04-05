<?php
namespace Modules\ChatDating\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\ChatDating\app\Models\UserChat;
use Spatie\Permission\Models\Role;

class UserChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles for web users only
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Create admin user
        $admin = UserChat::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'latitude' => -6.200000,
                'longitude' => 106.816666,
            ]
        );
        $admin->assignRole($adminRole);

        // Create regular user
        $user1 = UserChat::updateOrCreate(
            ['email' => 'user1@example.com'],
            [
                'name' => 'User One',
                'password' => Hash::make('password'),
                'latitude' => -6.201000,
                'longitude' => 106.817000,
            ]
        );
        $user1->assignRole($userRole);

        // Create API admin user (but use web guard for roles)
        $apiAdmin = UserChat::updateOrCreate(
            ['email' => 'api_admin@example.com'],
            [
                'name' => 'API Admin',
                'password' => Hash::make('password'),
                'latitude' => -6.204000,
                'longitude' => 106.820000,
            ]
        );
        $apiAdmin->assignRole($adminRole); // Now using web guard role

        // Create API user (but use web guard for roles)
        $apiUser1 = UserChat::updateOrCreate(
            ['email' => 'api_user1@example.com'],
            [
                'name' => 'API User One',
                'password' => Hash::make('password'),
                'latitude' => -6.205000,
                'longitude' => 106.821000,
            ]
        );
        $apiUser1->assignRole($userRole); // Now using web guard role
    }
}