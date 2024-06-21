<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Buat role 'admin' jika belum ada
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Buat pengguna admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            // 'role_id' => $adminRole->id,
        ]);

        // Tetapkan peran 'admin' ke pengguna yang baru dibuat
        $admin->assignRole('admin');
    }
}
