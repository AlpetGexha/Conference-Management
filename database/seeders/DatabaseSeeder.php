<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Attendee;
use App\Models\Conference;
use App\Models\Speaker;
use App\Models\Talk;
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


        $venues = Venue::factory(50)->create();

        $talk = Talk::factory(500)->create();

        $speaker = Speaker::factory(500)
            ->withTalks(3)
            ->recycle(
                Conference::factory(10)
                    ->recycle($venues)
                    ->create()
            )
            ->create();

        $conference = Conference::factory(20)
            ->recycle($venues)
            ->hasAttached($speaker)
            ->hasAttached($talk)
            ->create();

        $attendee = Attendee::factory(200)
            ->forConference($conference->random()->first())
            ->create();
    }
}
