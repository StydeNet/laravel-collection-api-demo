<?php

namespace App\Api\Concerns;

use Illuminate\Support\Str;

trait HasDynamicAttributes
{
    protected $attributes = [];

    public function __construct(array $attributes = array())
    {
        $this->attributes = $attributes;
    }

    public function getAttribute($name)
    {
        $customGetter = 'get'.Str::studly($name).'Attribute';

        $value = array_key_exists($name, $this->attributes)
            ? $this->attributes[$name]
            : null;

        if (method_exists($this, $customGetter)) {
            return $this->$customGetter($value);
        }

        return $value;
    }

    public function __get($name)
    {
        return $this->getAttribute($name);
    }

    public function __isset($name)
    {
        $customGetter = 'get'.Str::studly($name).'Attribute';
        if (method_exists($this, $customGetter)) {
            return true;
        }

        return array_key_exists($name, $this->attributes);
    }

    public function toArray()
    {
        return $this->attributes;
    }
}
