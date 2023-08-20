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
        $users = [
            [
                'name' => 'Javlonbek Tuychiyev',
                'email' => 'faq@gmail.com',
                'phone' => '+998909999999',
                'password' => Hash::make('123456')
            ]
        ];

        User::truncate();
        User::insert($users);
    }
}
