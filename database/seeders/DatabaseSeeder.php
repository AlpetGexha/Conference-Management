<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Conference;
use App\Models\Speaker;
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
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::factory()->create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
            ]);
        }

        $this->command->info('Seeding the database 1');

        $venues = Venue::factory(50)->create();
        $this->command->info('Seeding the database2');
        $conference = Conference::factory(100)
            ->recycle($venues)
            ->create();
        $this->command->info('Seeding the database 3');
        $speaker = Speaker::factory(500)
            ->withTalks(3)
            ->recycle($conference)
            ->create();
        $this->command->info('Seeding the database 4');

    }
}
