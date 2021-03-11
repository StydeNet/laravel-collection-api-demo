<?php

namespace App\Providers;

use App\Api\Contracts\GetPlaylistsWithVideos;
use App\Api\GetExternalPlaylistsWithVideos;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(GetPlaylistsWithVideos::class, function () {
            return new GetExternalPlaylistsWithVideos;
        });
    }
}
