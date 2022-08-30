<?php

namespace App\Http\Composers;

use App\Repositories\DeliveryRepository;
use App\Resources\DeliveryResource;
use Illuminate\View\View;

class DeliveriesComposer
{
    public function compose(View $view): void
    {
        $deliveries = DeliveryResource::collection(
            app(DeliveryRepository::class)->activeDeliveries()
        );

        $view->with(compact('deliveries'));
    }
}