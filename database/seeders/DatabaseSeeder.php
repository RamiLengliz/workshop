<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default admin account
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@cafe.test'],
            [
                'name'     => 'Admin',
                'password' => bcrypt('admin123'),
                'role'     => 'admin',
            ]
        );

        // Sample waiter account
        \App\Models\User::updateOrCreate(
            ['email' => 'serveur@cafe.test'],
            [
                'name'     => 'Serveur Demo',
                'password' => bcrypt('serveur123'),
                'role'     => 'waiter',
            ]
        );

        foreach (range(1, 8) as $number) {
            \App\Models\TableCafe::firstOrCreate(['number' => $number]);
        }

        $this->call(CafeMenuSeeder::class);
    }
}
