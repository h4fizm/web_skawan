<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear all roles and permissions to avoid duplicates
        Role::truncate();
        Permission::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create roles
        $superAdminRole = Role::create(['name' => 'admin']);
        $adminRole = Role::create(['name' => 'konselor']);
        $userRole = Role::create(['name' => 'user_konseling']);

        // Create permissions based on the menu
        $permissions = [
            'lihat-beranda',
            'buat-konseling',
            'lihat-konseling',
            'lihat-dokumentasi-konseling',
            'manage-artikel',
            'lihat-peran',
            'lihat-perizinan',
            'manage-konselor'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $superAdminRole->givePermissionTo(Permission::all()); // Full access

        $adminRole->givePermissionTo([
            'lihat-beranda',
            'lihat-konseling',
            'lihat-dokumentasi-konseling',
        ]);

        $userRole->givePermissionTo([
            'buat-konseling',
            'lihat-konseling',
        ]);
    }
}
