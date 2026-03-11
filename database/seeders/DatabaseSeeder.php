<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'dudasadam'],
            [
                'name'     => 'Dudás Ádám',
                'password' => \Illuminate\Support\Facades\Hash::make('xai6Ahp3ai!'),
                'role'     => 'superadmin',
                'status'   => 'active',
            ]
        );
    }
}
