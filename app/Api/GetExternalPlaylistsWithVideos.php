<?php

namespace App\Api;

use App\Api\Contracts\GetPlaylistsWithVideos;
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
                return [
                    'title' => $row['title'],
                    'description' => $row['description'],
                    'length' => $row['length'],
                    'score' => $row['likes'] + $row['views'],
                    'channel' => $row['channel']['name'],
                    'author' => $row['channel']['author']['name'],
                    'tags' => collect(explode(',', $row['tags']))
                        ->map(function ($tag) {
                            return ucfirst($tag);
                        })
                        ->all(),
                    'playlist' => $row['playlist'],
                ];
            })
            ->groupBy('playlist')
            ->map(function ($videos, $playlistName) {
                return [
                    'name' => Str::title($playlistName),
                    'length' => $videos->sum('length'),
                    'videos' => $videos
                ];
            });
    }
}
