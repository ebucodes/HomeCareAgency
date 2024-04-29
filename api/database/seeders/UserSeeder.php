<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roles = ['admin', 'client', 'staff'];

        foreach ($roles as $index => $role) {
            $email = "test." . $role . "@example.com";
            $phone = '123456789' . $index;

            if (User::where('email', $email)->orWhere('phone', $phone)->exists()) {
                continue;
            }

            $user = User::create([
                'userName' => "test{$role}",
                'firstName' => "Test",
                'lastName' => ucfirst($role),
                'email' => $email,
                'phone' => $phone,
                'password' => Hash::make('password'),
                'role' => $role,
                'isActive' => true
            ]);
        }
    }
}
