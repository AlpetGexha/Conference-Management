<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Conference;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);

        //        $venues = Venue::factory(10)->create();
        //
        //        $conference = Conference::factory(100)
        //            ->recycle($venues)
        //            ->create();

    }
}
