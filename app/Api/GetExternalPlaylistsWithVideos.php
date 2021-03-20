<?php

namespace App\Api;

use App\Api\Contracts\GetPlaylistsWithVideos;
use App\Api\Entities\Playlist;
use App\Api\Entities\Video;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GetExternalPlaylistsWithVideos implements GetPlaylistsWithVideos
{
    public function get(): Collection
    {
        $apiUrl = url('api/external-videos'); // https://external-videos.com/videos

        $response = Http::get($apiUrl);

        $data = $response->json()['data'];

        return collect($data)
            ->map(function ($row) {
                return new Video([
                    'title' => $row['title'],
                    'description' => $row['description'],
                    'length' => $row['length'],
                    'likes' => $row['likes'],
                    'views' => $row['views'],
                    'channel' => $row['channel']['name'],
                    'author' => $row['channel']['author']['name'],
                    'tags' => collect(explode(',', $row['tags']))
                        ->map(function ($tag) {
                            return ucfirst($tag);
                        })
                        ->all(),
                    'playlist' => $row['playlist'],
                ]);
            })
            ->groupBy('playlist')
            ->map(function ($videos, $playlistName) {
                return new Playlist(Str::title($playlistName), $videos);
            });
    }
}
