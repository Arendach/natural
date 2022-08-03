<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Cache;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
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
            'categories'       => $this->mapCategories($categories),
            'meta_keywords'    => setting('Сео keywords головної сторінки'),
            'meta_description' => setting('Сео description головної сторінки'),
        ];

        return view('pages.index', $data);
    }

    private function mapCategories(Collection $categories): array
    {
        return $categories->map(function (Category $category) {
            return [
                'id'               => $category->id,
                'url'              => $category->getUrl(),
                'description'      => $category->description,
                'title'            => $category->title,
                'productsCount'    => $category->products_count,
                'allProductsCount' => $category->products()->count(),
                'products'         => $category->products->map(function (Product $product) {
                    return [
                        'id'         => $product->id,
                        'title'      => $product->title,
                        'picture'    => $product->getPicture(),
                        'pictureMin' => $product->getPictureMin(),
                        'url'        => $product->getUrl(),
                        'price'      => $product->price,
                        'discount'   => $product->discount,
                    ];
                })->toArray()
            ];
        })->toArray();
    }
}
