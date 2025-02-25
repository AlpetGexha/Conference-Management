<?php
namespace App\Filament\Resources\ConferenceResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\ConferenceResource;
use Illuminate\Routing\Router;


class ConferenceApiService extends ApiService
{
    protected static string | null $resource = ConferenceResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];
        
    }
}
