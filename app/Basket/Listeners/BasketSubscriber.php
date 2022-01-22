<?php


namespace App\Basket\Listeners;




use App\Basket\Services\BasketAdapterService;
use App\Basket\Services\ActualBasketService;

class BasketSubscriber
{

    public function handleGetBasket($event) {

        $basketAdapterService = new BasketAdapterService();

        if ($basketAdapterService->validate($event->input)->fails() ) {

            $response = $basketAdapterService->response();

            return response()->json($response);
        }


        $basketService = new ActualBasketService();

        $basket = $basketService->basket($basketAdapterService);

        return $basket;

    }


    public function subscribe($events)
    {

        $events->listen(
            'App\Basket\Events\BasketListEvent',
            'App\Basket\Listeners\BasketSubscriber@handleGetBasket'
        );

    }
}
