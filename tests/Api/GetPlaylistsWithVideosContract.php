<?php

namespace Tests\Api;

use App\Api\Contracts\GetPlaylistsWithVideos;
use App\Api\Entities\Playlist;
use App\Api\Entities\Video;
use Illuminate\Support\Collection;
use Tests\TestCase;

abstract class GetPlaylistsWithVideosContract extends TestCase
{
    /** @test */
    function get_playlists_with_videos()
    {
        $gateway = $this->gateway();

        $this->assertInstanceOf(GetPlaylistsWithVideos::class, $gateway);

        $result = $gateway->get();

        $this->assertInstanceOf(Collection::class, $result);

        $result->each(function ($playlist) {
            $this->assertInstanceOf(Playlist::class, $playlist);

            $this->assertInstanceOf(Collection::class, $playlist->getVideos());

            $playlist->getVideos()->each(function ($video) {
                $this->assertInstanceOf(Video::class, $video);
            });
        });

        $this->assertSame($this->getJsonData('videos'), $result->toArray());
    }

    abstract protected function gateway();

    protected function getJsonData($filename)
    {
        return json_decode(file_get_contents(__DIR__."/data/{$filename}.json"), JSON_OBJECT_AS_ARRAY);
    }
}
