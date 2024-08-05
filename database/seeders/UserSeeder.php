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
        User::create([
            'name' => 'Haniel R',
            'email' => 'h.r@gmail.com',
            'password' => Hash::make('1234567890')
        ])->assignRole('Administrator');

        User::create([
            'name' => 'Mizraim Salazar',
            'email' => 'm.sala@gmail.com',
            'password' => Hash::make('1234567890')
        ])->assignRole('Author');

        User::factory(10)->create();
    }
}
