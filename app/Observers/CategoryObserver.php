<?php

namespace App\Observers;

use App\Models\Category;
use Cache;

class CategoryObserver
{
    public function created(Category $category): void
    {
        $this->cacheClear();
    }

    public function updated(Category $category): void
    {
        $this->cacheClear();
    }

    public function deleted(Category $category): void
    {
        $this->cacheClear();
    }

    private function cacheClear(): void
    {
        Cache::forget('mainPageItems');
    }
}
