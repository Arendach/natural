<?php

namespace App\Http\Controllers;

use App\Repositories\BannerRepository;
use App\Repositories\CategoryRepository;
use App\Transformers\BannersTransformer;
use App\Transformers\CategoryWithProductsTransformer;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(private CategoryRepository $repository)
    {
    }

    public function index(string $slug): View
    {
        $category = $this->repository->getCategoryWithProducts($slug);

        $data = [
            'page'             => $category,
            'seo'              => $category->getSeo(),
            'breadcrumbs'      => $category->getBreadcrumbs(),
            'categoryResource' => app(CategoryWithProductsTransformer::class)->run($category),
            'banners'          => app(BannersTransformer::class)->run(
                app(BannerRepository::class)->getBanners()
            )
        ];

        return view('pages.category', $data);
    }
}
