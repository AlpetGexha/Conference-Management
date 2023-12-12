<?php

use App\Enums\TalkLenght;
use App\Enums\TalkStatus;
use App\Models\Speaker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('talks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('abstract');
            $table->string('length')->default(TalkLenght::NORMAL);
            $table->string('status')->default(TalkStatus::SUBMITTED);
            $table->boolean('new_talk')->default(false);
            $table->foreignIdFor(Speaker::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('talks');
    }
};
