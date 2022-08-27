<?php

namespace App\Http\Controllers;

use App\Repositories\BannerRepository;
use App\Repositories\CategoryRepository;
use App\Resources\BannerResource;
use App\Resources\CategoryResource;
use Illuminate\View\View;

class CategoryController extends Controller
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(string $slug): View
    {
        $category = $this->repository->getCategoryWithProducts($slug);

        $data = [
            'page'             => $category,
            'seo'              => $category->getSeo(),
            'breadcrumbs'      => $category->getBreadcrumbs(),
            'categoryResource' => new CategoryResource($category),
            'banners'          => BannerResource::collection(app(BannerRepository::class)->getBanners()),
        ];

        return view('pages.category', $data);
    }
}
