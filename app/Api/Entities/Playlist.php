<?php

namespace App\Api\Entities;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class Playlist implements Arrayable
{
    private string $name;
    /**
     * @var Collection
     */
    private $videos;

    public function __construct($name, Collection $videos)
    {
        $this->name = $name;
        $this->videos = $videos;
    }

    public function getMostViewedVideo(): array
    {
        return $this->videos->sortByDesc('views')->first();
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'videos' => $this->videos,
            'length' => $this->videos->sum('length'),
        ];
    }
}
