<?php

namespace App\Http\Controllers;

use App\Actions\CreateOrderAction;
use App\Models\Order;
use App\Repositories\BannerRepository;
use App\Resources\BannerResource;
use App\Resources\OrderResource;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function create(CreateOrderAction $action): JsonResponse
    {
        $order = $action->run();

        session()->put('lastOrder', $order->id);

        return response()
            ->json(['redirectUrl' => route('thank.order', [$order->id])])
            ->withCookie(cookie('cartProducts', '', -9999, '/'));
    }

    public function thank(Order $order): View
    {
        //abort_if(session('lastOrder') != $order->id, 404);

        $order->load('products');

        $title = "Замовлення прийняте! Id: $order->id";
        $breadcrumbs = [['Замовлення прийняте']];
        $banners = BannerResource::collection(app(BannerRepository::class)->getBanners());
        $order = new OrderResource($order);

        return view('pages.thank', compact('order', 'banners', 'title', 'breadcrumbs'));
    }
}