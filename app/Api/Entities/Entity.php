<?php

namespace App\Api\Entities;

use App\Api\Concerns\HasDynamicAttributes;
use Illuminate\Contracts\Support\Arrayable;

class Entity implements Arrayable
{
    use HasDynamicAttributes;
}
