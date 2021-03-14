<?php

namespace Tests\Api\Entities;

use App\Api\Entities\Playlist;
use Tests\TestCase;

class PlaylistTest extends TestCase
{
    /** @test */
    function get_most_viewed_video()
    {
        $videos = collect([
            [
                'title' => 'My video title',
                'description' => 'My description',
                'length' => 999,
                'score' => 9999,
                'views' => 500,
                'channel' => 'My channel',
                'author' => 'Duilio Palacios',
                'tags' => ['Tag 1', 'Tag 2'],
                'playlist' => 'My Playlist',
            ],
            [
                'title' => 'Most Viewed Video',
                'description' => 'My description',
                'length' => 999,
                'score' => 9999,
                'views' => 1000,
                'channel' => 'My channel',
                'author' => 'Duilio Palacios',
                'tags' => ['Tag 1', 'Tag 2'],
                'playlist' => 'My Playlist',
            ],
            [
                'title' => 'My video title 3',
                'description' => 'My description',
                'length' => 999,
                'score' => 9999,
                'views' => 200,
                'channel' => 'My channel',
                'author' => 'Duilio Palacios',
                'tags' => ['Tag 1', 'Tag 2'],
                'playlist' => 'My Playlist',
            ],
        ]);

        $playlist = new Playlist('My Playlist', $videos);

        $this->assertSame('Most Viewed Video', $playlist->getMostViewedVideo()['title']);
    }
}
