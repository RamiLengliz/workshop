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
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@cafe.test'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );

        foreach (range(1, 8) as $number) {
            \App\Models\TableCafe::firstOrCreate(['number' => $number]);
        }

        $this->call(CafeMenuSeeder::class);
    }
}
