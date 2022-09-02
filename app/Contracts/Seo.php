<?php

namespace App\Contracts;

interface Seo
{
    public function getOGImage(): string|null;
}