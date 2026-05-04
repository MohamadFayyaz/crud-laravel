<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 10, Jakarta',
                'hobbies' => ['Membaca', 'Bersepeda', 'Fotografi'],
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad@example.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 10, Jakarta',
                'hobbies' => ['Membaca', 'Bersepeda', 'Fotografi'],
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti@example.com',
                'password' => Hash::make('password123'),
                'phone' => '082345678901',
                'address' => 'Jl. Sudirman No. 25, Bandung',
                'hobbies' => ['Memasak', 'Menari', 'Travelling'],
            ],
        ];

        foreach ($users as $userData) {
            $hobbies = $userData['hobbies'];
            unset($userData['hobbies']);

            $user = User::create($userData);

            foreach ($hobbies as $hobbyName) {
                $user->hobbies()->create(['name' => $hobbyName]);
            }
        }
    }
}
