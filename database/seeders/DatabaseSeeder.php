<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Users;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Users::create([
            'user' => 'admin',
            'email' => 'admin@email.com.br',
            'type' => 'admin',
            'password' => Hash::make('admin%123'),
        ]);

        Users::create([
            'user' => 'user',
            'email' => 'user@email.com.br',
            'type' => 'user',
            'password' => Hash::make('user_123'),
        ]);
    }
}
