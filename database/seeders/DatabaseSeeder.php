<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table("tea_types")->insert([
            ['name' => 'Black'],
            ['name' => 'Green'],
            ['name' => 'Yellow'],
            ['name' => 'Oolong'],
            ['name' => 'White'],
            ['name' => 'Puerh'],
            ['name' => 'Red'],
            ['name' => 'Matcha'],
        ]);



    }
}
