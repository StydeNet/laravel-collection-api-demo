<?php

namespace App\Api\Entities;

use App\Api\Concerns\HasDynamicAttributes;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @property int views
 * @property int likes
 * @property int score
 */
class Video extends Entity
{
    public function getScoreAttribute()
    {
        return $this->views + $this->likes;
    }

    public function toArray()
    {
        return array_merge(
            parent::toArray(), [
                'score' => $this->score,
            ]
        );
    }
}
