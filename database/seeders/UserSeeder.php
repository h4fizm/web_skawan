<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Document;
use App\Models\Institution;
use App\Models\Konselor;
use App\Models\Pic;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Admin', 'email' => 'admin@sekawan.com', 'password' => Hash::make('password'),],
            ['name' => 'Operator', 'email' => 'operator@sekawan.com', 'password' => Hash::make('password'),],
        ];

        $super_admin = User::create($users[0]);
        $super_admin->syncRoles('admin');

        $operator = User::create($users[1]);
        $operator->syncRoles('operator');
    }
}
