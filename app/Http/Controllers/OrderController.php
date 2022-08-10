<?php

namespace App\Http\Controllers;

use App\Actions\CreateOrderAction;
use App\Models\Banner;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function create(CreateOrderAction $action): JsonResponse
    {
        $order = $action->run();

        setcookie('cartProducts', '', time() - 99999, '/');

        session()->put('lastOrder', $order->id);

        return response()->json([
            'redirectUrl' => route('thank', [$order->id])
        ]);
    }

    public function thank(Order $order): View
    {
        if (session('lastOrder') != $order->id) {
            abort(404);
        }

        $banners = Banner::where('is_active', true)
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

        $products = $order->products->map(function (Product $product) {
            return [
                'id'         => $product->id,
                'title'      => $product->title,
                'picture'    => (string)$product->getImage('picture', 474, 474, 50),
                'pictureMin' => $product->getPictureMin(),
                'url'        => $product->getUrl(),
                'price'      => $product->pivot->price,
                'discount'   => $product->discount,
                'count'      => $product->pivot->count,
            ];
        });

        $title = 'Замовлення оформлено! Id:' . $order->id;
        $breadcrumbs = [['Замовлення оформлено']];

        return view('pages.thank', compact('order', 'banners', 'products', 'title', 'breadcrumbs'));
    }
}