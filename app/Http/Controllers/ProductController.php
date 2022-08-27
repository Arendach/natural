<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\DeliveryRepository;
use App\Resources\DeliveryResource;
use App\Resources\ProductResource;

class ProductController extends Controller
{
    public function index(Product $product)
    {
        abort_if(!$product->is_active, 404);

        $product->load('relatedImages', 'relatedImages.images', 'images');

        $data = [
            'title'            => $product->seo->title,
            'meta_description' => $product->seo->description,
            'meta_keywords'    => $product->seo->keywords,
            'product'          => new ProductResource($product),
            'breadcrumbs'      => [
                [$product->category->title, $product->category->getUrl()],
                [$product->title]
            ],
            'deliveries'       => DeliveryResource::collection(app(DeliveryRepository::class)->activeDeliveries()),
            'seo'              => $product->getSeo(),
        ];

        return view('pages.product', $data);
    }
}
