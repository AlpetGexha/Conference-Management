<?php

use App\Models\Conference;
use App\Models\Talk;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conference_talk', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Conference::class);
            $table->foreignIdFor(Talk::class);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conference_talk');
    }
};
