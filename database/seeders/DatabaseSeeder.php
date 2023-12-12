<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Attendee;
use App\Models\Conference;
use App\Models\Speaker;
use App\Models\Talk;
use App\Models\User;
use App\Models\Venue;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Helper\ProgressBar;

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

        $venues = $this->withProgressBar(20, fn() => Venue::factory(50)->create());
        $talks = $this->withProgressBar(20, fn() => Talk::factory(50)->create());


        $speaker = Speaker::factory(500)
            ->withTalks(3)
            ->recycle(
                Conference::factory(10)
                    ->recycle($venues)
                    ->create()
            )
            ->create();

        $speakers = $this->withProgressBar(40, fn() => Speaker::factory(3)
            ->withTalks(2)
            ->recycle(
                Conference::factory(2)
                    ->recycle($venues)
                    ->create()
            )
            ->create());

        $conferences = $this->withProgressBar(20, fn() => Conference::factory(4)
            ->recycle($venues)
            ->hasAttached($speaker)
            ->hasAttached($talks)
            ->create());

        $attendees = $this->withProgressBar(20, fn() => Attendee::factory(1000)
            ->recycle($conferences)
            ->create());
    }


    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection();

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
}
