<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\BannerRepository;
use App\Transformers\BannersTransformer;
use Cache;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function index(): View
    {
        $data = [
            'title'            => setting('Сео title головної сторінки', ''),
            'categories'       => $this->getCategories(),
            'meta_keywords'    => setting('Сео keywords головної сторінки'),
            'meta_description' => setting('Сео description головної сторінки'),
            'banners'          => app(BannersTransformer::class)->run(
                app(BannerRepository::class)->getBanners()
            ),
        ];

        return view('pages.index', $data);
    }

    private function getCategories(): array
    {
        return Cache::rememberForever('categoriesWithProducts', function () {
            $categories = Category::withCount('products')->orderByDesc('priority')->get();

            $categories->each(function (Category $category) {
                $category->load(['products' => function (HasMany $builder) {
                    $builder->limit(setting('Кількість товарів в категорії'))
                        ->where('is_active', true)
                        ->orderByDesc('priority');
                }, 'products.images']);
            });

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
        });
    }
}
