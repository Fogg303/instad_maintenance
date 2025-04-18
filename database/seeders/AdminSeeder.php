<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'kpataclojunior56@gmail.com',
            'password' => Hash::make('admin123'), // Change le mot de passe si besoin
            'role' => 'admin',
        ]);
    }
}