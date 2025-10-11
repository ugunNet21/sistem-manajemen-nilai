<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    private const PERMISSIONS = [
        'view-dashboard',
        'manage-siswa',
        'manage-nilai',
        'import-excel',
        'export-excel',
    ];

    /**
     * Run the seeder.
     */
    public function run(): void
    {
        // Create or update permissions
        foreach (self::PERMISSIONS as $permission) {
            Permission::updateOrCreate(
                [
                    'name' => $permission,
                    'guard_name' => 'web',
                ],
                [
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Assign permissions to roles
        $adminRole = Role::findByName('Admin', 'web');
        $teacherRole = Role::findByName('Teacher', 'web');
        $studentRole = Role::findByName('Student', 'web');

        $adminRole->syncPermissions(Permission::all());

        $teacherPermissions = Permission::whereIn('name', [
            'view-dashboard',
            'manage-siswa',
            'manage-nilai',
        ])->get();
        $teacherRole->syncPermissions($teacherPermissions);

        $studentPermissions = Permission::where('name', 'view-dashboard')->get();
        $studentRole->syncPermissions($studentPermissions);

        $this->command->info('PermissionSeeder selesai dijalankan.');
    }
}
