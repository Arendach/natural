<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\BannerRepository;
use App\Resource\AnonymousResourceCollection;
use App\Resources\BannerResource;
use App\Resources\CategoryResource;
use Cache;
use Illuminate\Database\Eloquent\Builder;
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
            'banners'          => BannerResource::collection(app(BannerRepository::class)->getBanners()),
        ];

        return view('pages.index', $data);
    }

    private function getCategories(): AnonymousResourceCollection
    {
        return Cache::rememberForever('categoriesWithProducts', function () {
            $categories = Category::withCount([
                'products' => function (Builder $builder) {
                    $builder->where('is_active', true);
                }
            ])->orderByDesc('priority')->get();

            $categories->each(function (Category $category) {
                $category->load(['products' => function (HasMany $builder) {
                    $builder->limit(setting('Кількість товарів в категорії'))
                        ->where('is_active', true)
                        ->orderByDesc('priority');
                }, 'products.images']);
            });

            return CategoryResource::collection($categories);
        });
    }
}
