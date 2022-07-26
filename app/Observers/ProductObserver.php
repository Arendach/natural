<?php

namespace App\Observers;

use App\Models\Product;
use Cache;

class ProductObserver
{
    public function created(Product $product): void
    {
        $this->cacheClear();
    }

    public function updating(Product $product): void
    {
        $this->cacheClear();
    }

    public function deleted(Product $product): void
    {
        $this->cacheClear();
    }

    private function cacheClear(): void
    {
        Cache::forget('mainPageItems');
    }
}
