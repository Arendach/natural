<?php

namespace App\Http\Composers;

use App\Models\Category;
use Illuminate\View\View;
use Cache;

class MainComposer
{
    public function compose(View $view): void
    {
        $categories = Cache::rememberForever('categoriesInMainComposer', function () {
            return Category::withCount('products')->orderByDesc('priority')->get();
        });

        $view->with(compact('categories'));
    }
}