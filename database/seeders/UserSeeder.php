<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the seeder.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@sekolahku.com',
                'password' => 'password',
                'role' => 'Admin',
            ],
            [
                'name' => 'Teacher User',
                'email' => 'teacher@sekolahku.com',
                'password' => 'password',
                'role' => 'Teacher',
            ],
            [
                'name' => 'Student User',
                'email' => 'student@sekolahku.com',
                'password' => 'password',
                'role' => 'Student',
            ],
            [
                'name' => 'Zaki User',
                'email' => 'zaki@sekolahku.com',
                'password' => 'password',
                'role' => 'Student',
            ],
        ];

        foreach ($users as $data) {
            // Create or update user by email
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'email_verified_at' => now(),
                    'password' => Hash::make($data['password']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Assign role
            $role = Role::where('name', $data['role'])->first();
            if (!$role) {
                throw new \Exception("Role '{$data['role']}' tidak ditemukan di database.");
            }
            $user->syncRoles([$role]);
        }

        $this->command->info('UserSeeder selesai dijalankan.');
    }
}