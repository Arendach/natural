<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Cache;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function index(): View
    {
        $categories = Cache::rememberForever('mainPageItems', function () {
            $items = Category::withCount('products')->orderByDesc('priority')->get();

            $items->each(function (Category $category) {
                $category->load(['products' => function (HasMany $builder) {
                    $builder->limit(setting('Кількість товарів в категорії'))
                        ->orderByDesc('priority');
                }]);
            });

            return $items;
        });

        $data = [
            'title'            => setting('Сео title головної сторінки', ''),
            'categories'       => $categories,
            'meta_keywords'    => setting('Сео keywords головної сторінки'),
            'meta_description' => setting('Сео description головної сторінки'),
        ];

        return view('pages.index', $data);
    }
}
