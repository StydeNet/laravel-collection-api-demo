<?php

namespace Tests\Api\Entities;

use App\Api\Entities\Video;
use Tests\TestCase;

class VideoTest extends TestCase
{
    /** @test */
    function can_instantiate_a_video_object()
    {
        $video = new Video([
            'title' => 'Title of the video',
        ]);

        $this->assertSame('Title of the video', $video->title);
    }

    /** @test */
    function can_export_a_video_as_an_array()
    {
        $video = new Video([
            'title' => 'Title of the video',
            'description' => 'Description of the video',
        ]);

        $expected = [
            'title' => 'Title of the video',
            'description' => 'Description of the video',
            'score' => 0,
        ];
        $this->assertSame($expected, $video->toArray());
    }

    /** @test */
    function can_calculate_the_score_of_a_video()
    {
        $video = new Video([
            'likes' => 500,
            'views' => 1000,
        ]);

        $this->assertTrue(isset($video->score));
        $this->assertSame(1500, $video->score);
    }
}
