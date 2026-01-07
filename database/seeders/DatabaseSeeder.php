<?php

namespace Database\Seeders;

use App\Models\GlobalSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run roles and permissions seeder first
        $this->call(RolesAndPermissionsSeeder::class);

        // Create Super Admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('super-admin');

        // Create Admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Create Editor user
        $editor = User::create([
            'name' => 'Editor User',
            'email' => 'editor@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $editor->assignRole('editor');

        // Create Regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $user->assignRole('user');

        // Create default global settings
        GlobalSetting::set('site_name', 'Materio Laravel', 'text', 'general');
        GlobalSetting::set('site_description', 'Modern Admin Dashboard', 'text', 'general');
        GlobalSetting::set('maintenance_mode', false, 'boolean', 'general');
        GlobalSetting::set('registration_open', true, 'boolean', 'auth');
        GlobalSetting::set('default_user_role', 'user', 'text', 'auth');
        GlobalSetting::set('max_login_attempts', '5', 'text', 'security');
        GlobalSetting::set('lockout_duration', '15', 'text', 'security');

        // Create sample activity logs for dashboard charts
        $this->createSampleActivityLogs($superAdmin, $admin, $editor, $user);
    }

    private function createSampleActivityLogs($superAdmin, $admin, $editor, $user)
    {
        $users = [$superAdmin, $admin, $editor, $user];
        $logTypes = ['auth', 'user', 'role', 'permission', 'settings'];
        $descriptions = [
            'auth' => ['User logged in', 'User logged out', 'Password reset requested'],
            'user' => ['User created', 'User updated', 'User deleted', 'User status changed'],
            'role' => ['Role created', 'Role updated', 'Role deleted', 'Permissions assigned'],
            'permission' => ['Permission created', 'Permission updated', 'Permission deleted'],
            'settings' => ['Setting created', 'Setting updated', 'Setting deleted'],
        ];

        // Create 50 sample activities over the last 6 months
        for ($i = 0; $i < 50; $i++) {
            $logName = $logTypes[array_rand($logTypes)];
            $description = $descriptions[$logName][array_rand($descriptions[$logName])];
            $causer = $users[array_rand($users)];
            $daysAgo = rand(0, 180);

            \App\Models\ActivityLog::create([
                'log_name' => $logName,
                'description' => $description,
                'causer_type' => get_class($causer),
                'causer_id' => $causer->id,
                'properties' => ['ip' => '127.0.0.1', 'user_agent' => 'Mozilla/5.0'],
                'created_at' => now()->subDays($daysAgo),
                'updated_at' => now()->subDays($daysAgo),
            ]);
        }
    }
}
