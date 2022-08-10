<?php

namespace App\Http\Controllers;

use App\Models\Banner;
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
                        ->where('is_active', true)
                        ->orderByDesc('priority');
                }, 'products.images']);
            });

            return $items;
        });

        $data = [
            'title'            => setting('Сео title головної сторінки', ''),
            'categories'       => $this->mapCategories($categories),
            'meta_keywords'    => setting('Сео keywords головної сторінки'),
            'meta_description' => setting('Сео description головної сторінки'),
            'banners'          => $this->getBanners(),
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
                        'picture'    => (string)$product->getImage('picture', 474, 474, 50),
                        'pictureMin' => $product->getPictureMin(),
                        'url'        => $product->getUrl(),
                        'price'      => $product->price,
                        'discount'   => $product->discount,
                    ];
                })->toArray()
            ];
        })->toArray();
    }

    private function getBanners(): array
    {
        return Banner::where('is_active', true)
            ->with('images')
            ->orderByDesc('priority')
            ->get()
            ->map(function (Banner $banner) {
                return [
                    'id'              => $banner->id,
                    'title'           => $banner->title,
                    'url'             => $banner->url,
                    'color'           => $banner->color,
                    'picture_desktop' => $banner->getImage('picture_desktop', 1920, 400, 70),
                    'picture_mobile'  => $banner->getImage('picture_mobile', 991, 400, 70),
                ];
            })
            ->toArray();
    }
}
