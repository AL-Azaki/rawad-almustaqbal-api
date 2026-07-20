<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@abuturki.com'],
            [
                'name' => 'مدير النظام',
                'password' => bcrypt('password'),
            ]
        );    
    }
}