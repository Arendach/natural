<?php

namespace App\Models;

class Seo extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'seo';

    public function getH1(): string|null
    {
        return $this->h1;
    }

    public function getTitle(): string|null
    {
        return $this->title;
    }

    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function getKeywords(): string|null
    {
        return $this->keywords;
    }
}