<?php

namespace App\Api\Contracts;

use Illuminate\Support\Collection;

interface GetPlaylistsWithVideos
{
    public function get(): Collection;
}
