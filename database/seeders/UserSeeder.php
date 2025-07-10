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
            ['name' => 'Admin', 'username' => 'admin_bk_unimed', 'password' => Hash::make('12345678'),],
            ['name' => 'Konselor Pernah Konseling', 'username' => 'konselor_bk_unimed_1', 'password' => Hash::make('12345678'),],
            ['name' => 'Mahasiswa Unimed', 'username' => 'mahasiswa_unimed', 'password' => Hash::make('12345678'),],
            ['name' => 'Pegawai Unimed', 'username' => 'pegawai_unimed', 'password' => Hash::make('12345678'),],

            ['name' => 'Konselor Pengukuran Psikologi', 'username' => 'konselor_bk_unimed_2', 'password' => Hash::make('12345678'),],
            ['name' => 'Konselor Permasalahan Umum', 'username' => 'konselor_bk_unimed_3', 'password' => Hash::make('12345678'),],
        ];

        $super_admin = User::create($users[0]);
        $super_admin->syncRoles('admin');

        $konselor = User::create($users[1]);
        $konselor->syncRoles('konselor');
        Konselor::create([
            'user_id' => $konselor->id,
            'category' => 'Pernah Konseling'
        ]);
        $konselor_2 = User::create($users[4]);
        $konselor_2->syncRoles('konselor');
        Konselor::create([
            'user_id' => $konselor_2->id,
            'category' => 'Pengukuran Psikologi'
        ]);

        $konselor_3 = User::create($users[5]);
        $konselor_3->syncRoles('konselor');
        Konselor::create([
            'user_id' => $konselor_3->id,
            'category' => 'Permasalahan Umum'
        ]);
        
        $user_konseling_1 = User::create($users[2]);
        $user_konseling_1->syncRoles('user_konseling');

        $user_konseling_2 = User::create($users[3]);
        $user_konseling_2->syncRoles('user_konseling');
    }
}
