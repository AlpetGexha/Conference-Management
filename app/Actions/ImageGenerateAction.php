<?php

namespace App\Actions;

class ImageGenerateAction
{
    public static function handle(string $name): string
    {
        return "https://ui-avatars.com/api/?name={$name}&color=7F9CF5&background=EBF4FF";
    }
}
