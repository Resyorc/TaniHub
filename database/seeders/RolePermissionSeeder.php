<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Cek dan buat role admin jika belum ada
        if (Role::where('name', 'admin')->doesntExist()) {
            $roleAdmin = Role::create(['name' => 'admin']);
        } else {
            $roleAdmin = Role::where('name', 'admin')->first();
        }

        // Cek dan buat role user jika belum ada
        if (Role::where('name', 'user')->doesntExist()) {
            $roleUser = Role::create(['name' => 'user']);
        } else {
            $roleUser = Role::where('name', 'user')->first();
        }

        // Assign role ke user tertentu
        $admin = User::find(1); // Ganti dengan ID user admin Anda
        if ($admin) {
            $admin->assignRole($roleAdmin);
        }

        $user = User::find(2); // Ganti dengan ID user biasa Anda
        if ($user) {
            $user->assignRole($roleUser);
        }
    }
}
