<?php

namespace App\Vendor;

use Faker\Factory;
use Illuminate\Support\Arr;

class FakeVideoLibrary
{
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public static function make()
    {
        return new static();
    }

    public function latest(int $limit) : array
    {
        $results = $limit > 0 ? $this->getVideos($limit) : [];

        $pagination = $this->getPaginationLinks($results);

        return [
            'data' => $results,
            'pagination' => $pagination,
        ];
    }

    protected function getvideos(int $limit) : array
    {
        return collect(range(0, $limit - 1))->map(function () {
            return $this->getVideo();
        })->toArray();
    }

    public function getPaginationLinks(array $results) : array
    {
        return [
            'current_page' => 1,
            'total_results' => count($results),
            'first_page' => '/api/videos?page=1',
            'last_page' => '/api/videos?page=2',
        ];
    }

    protected function getVideo() : array
    {
        return [
            'uuid' => $this->faker->uuid,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'tags'  => implode(',', $this->getTags()),
            'length' => $this->faker->numberBetween(60, 500),
            'views' => $this->faker->numberBetween(500, 1500),
            'likes' => $this->faker->numberBetween(500, 1500),
            'channel' => $this->getChannel(),
            'url' => 'https://www.youtube.com/watch?v=XeVK7ibmqu8&ab_channel=DuilioPalacios',
            'playlist' => array_rand(array_flip(['unlisted', 'trending', 'news', 'sports'])),
        ];
    }

    protected function getTags(): array
    {
        return Arr::shuffle(array_merge($this->faker->words(5), $this->faker->randomElement([['featured'], []])));
    }

    protected function getChannel() : array
    {
        return [
            'uuid' => $this->faker->uuid,
            'name' => $this->faker->company,
            'subscribers' => $this->faker->numberBetween(0, 500),
            'author' => $this->getAuthor(),
        ];
    }

    protected function getAuthor() : array
    {
        return [
            'uuid' => $this->faker->uuid,
            'name' => $this->faker->name,
            'username' => $this->faker->userName,
            'verified'  => $this->faker->numberBetween(0, 1),
        ];
    }
}
