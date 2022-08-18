<?php

namespace App\Resource;

class AnonymousResourceCollection extends ResourceCollection
{
    public string $collects;

    public function __construct($resource, string $collects)
    {
        $this->collects = $collects;

        parent::__construct($resource);
    }
}
