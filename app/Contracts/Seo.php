<?php

namespace App\Contracts;

interface Seo
{
    public function getOGPicture(): string|null;
}