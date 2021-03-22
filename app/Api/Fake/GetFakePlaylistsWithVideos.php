<?php

namespace App\Api\Fake;

use App\Api\Contracts\GetPlaylistsWithVideos;
use App\Api\Entities\Playlist;
use App\Api\Entities\Video;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class GetFakePlaylistsWithVideos implements GetPlaylistsWithVideos
{
    public function get(): Collection
    {
        return collect(json_decode(File::get(__DIR__.'/data/videos.json'), JSON_OBJECT_AS_ARRAY))
            ->map(function ($playlist) {
                return new Playlist(
                    $playlist['name'],
                    collect($playlist['videos'])->mapInto(Video::class)
                );
            });
    }
}
