<?php

namespace Tests\Api;

use App\Api\GetExternalPlaylistsWithVideos;
use Illuminate\Support\Facades\Http;

/**
 * @group api
 */
class GetExternalPlaylistsWithVideosTest extends GetPlaylistsWithVideosContract
{
    protected function gateway()
    {
        Http::fake([
            url('api/external-videos') => Http::response($this->getJsonData('external-videos'), 200, [])
        ]);

        sleep(rand(1, 3));

        return new GetExternalPlaylistsWithVideos;
    }
}
