<?php

namespace Tests\Api;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class VideosTest extends TestCase
{
    /** @test */
    function gets_videos_grouped_by_playlist()
    {
        Http::fake([
            url('api/external-videos') => Http::response($this->getJsonData('external-videos'), 200, [])
        ]);

        $this->get('api/videos')
            ->assertExactJson($this->getJsonData('videos'));
    }

    protected function getJsonData($filename)
    {
        return json_decode(file_get_contents(__DIR__."/data/{$filename}.json"), JSON_OBJECT_AS_ARRAY);
    }
}
