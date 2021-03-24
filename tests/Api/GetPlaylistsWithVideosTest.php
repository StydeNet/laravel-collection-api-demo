<?php

namespace Tests\Api;

use App\Api\Contracts\GetPlaylistsWithVideos;
use App\Api\Entities\Playlist;
use App\Api\Entities\Video;
use App\Api\Fake\GetFakePlaylistsWithVideos;
use App\Api\GetExternalPlaylistsWithVideos;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetPlaylistsWithVideosTest extends TestCase
{
    /**
     * @test
     * @dataProvider gatewayProviders
     */
    function get_playlists_with_videos(Closure $gatewayFactory)
    {
        $gateway = $gatewayFactory();

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

    protected function getJsonData($filename)
    {
        return json_decode(file_get_contents(__DIR__."/data/{$filename}.json"), JSON_OBJECT_AS_ARRAY);
    }

    public function gatewayProviders()
    {
        return [
            'External Gateway' => [function () {
                Http::fake([
                    url('api/external-videos') => Http::response($this->getJsonData('external-videos'), 200, [])
                ]);

                return new GetExternalPlaylistsWithVideos;
            }],
            'Fake Gateway' => [function () {
                return new GetFakePlaylistsWithVideos;
            }],
        ];
    }
}
