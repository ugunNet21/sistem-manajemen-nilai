<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    private const ROLES = [
        'Admin',
        'Teacher',
        'Student',
    ];

    /**
     * Run the seeder.
     */
    public function run(): void
    {
        foreach (self::ROLES as $roleName) {
            Role::updateOrCreate(
                [
                    'name' => $roleName,
                    'guard_name' => 'web',
                ],
                [
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('RoleSeeder selesai dijalankan.');
    }
}
