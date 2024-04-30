<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// class UserSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         //
//         $roles = ['admin', 'client', 'worker'];

//         foreach ($roles as $index => $role) {
//             $email = "test." . $role . "@example.com";
//             $phone = '123456789' . $index;

//             if (User::where('email', $email)->orWhere('phone', $phone)->exists()) {
//                 continue;
//             }

//             $user = User::create([
//                 'userName' => "test{$role}",
//                 'firstName' => "Test",
//                 'lastName' => ucfirst($role),
//                 'email' => $email,
//                 'phone' => $phone,
//                 'password' => Hash::make('password'),
//                 'role' => $role,
//                 'isActive' => true,
//             ]);
//         }
//     }
// }

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin'];

        foreach ($roles as $index => $role) {
            $email = "test." . $role . "@example.com";
            $phone = '123456789' . $index;

            if (User::where('email', $email)->orWhere('phone', $phone)->exists()) {
                continue;
            }

            $data = [
                'userName' => "test{$role}",
                'firstName' => "Test",
                'lastName' => ucfirst($role),
                'email' => $email,
                'phone' => $phone,
                'password' => Hash::make('password'),
                'role' => $role,
                'isActive' => true,
            ];

            if ($role === 'client') {
                // If the role is 'client', set the 'worker' field to the userName of the client created
                $data['worker'] = 'testworker';
            }

            $user = User::create($data);
        }
    }
}
