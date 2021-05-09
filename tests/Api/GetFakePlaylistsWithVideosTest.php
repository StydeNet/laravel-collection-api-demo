<?php

namespace Tests\Api;

use App\Api\Fake\GetFakePlaylistsWithVideos;

class GetFakePlaylistsWithVideosTest extends GetPlaylistsWithVideosContract
{
    protected function gateway()
    {
        return new GetFakePlaylistsWithVideos;
    }
}
