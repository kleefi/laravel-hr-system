<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);

        // Assign role ke user
        $admin = User::firstOrCreate(
            ['email' => 'decharvi.charles@gmail.com'],
            ['name' => 'Admin', 'password' => bcrypt('asdfasdf')]
        );
        $admin->assignRole($adminRole);

        // $employee = User::firstOrCreate(
        //     ['email' => 'employee@example.com'],
        //     ['name' => 'Employee', 'password' => bcrypt('asdfasdf')]
        // );
        // $employee->assignRole($employeeRole);
    }
}
