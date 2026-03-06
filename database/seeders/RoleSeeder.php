<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            1 => 'Admin',
            2 => 'Operator',
            3 => 'Mahasiswa',
            4 => 'Dosen'
        ];

        foreach ($roles as $id => $role) {
            Role::firstOrCreate(
                ['id' => $id],
                ['nama_role' => $role]
            );
        }
    }
}
