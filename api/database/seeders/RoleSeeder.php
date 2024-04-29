<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roles = ['admin', 'client', 'staff'];

        foreach ($roles as $index => $role) {
            $role = Role::create([
                'name' => $role,
                'isActive' => true
            ]);
        }
    }
}
