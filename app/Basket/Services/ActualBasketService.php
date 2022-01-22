<?php


namespace App\Basket\Services;



use App\Basket\Models\ActualBasketModel;
use App\Products\Models\ActualProductModel;
use Illuminate\Support\Facades\DB;
use Exception;

class ActualBasketService
{

    public function basket(BasketAdapterService $basketAdapterService) {

        try {

            $product_ids = $basketAdapterService->getProductIds();

            $products = ActualBasketModel::whereIn('ccp.id', $product_ids)->get()->toArray();

            if(empty($products)) {
                $basketAdapterService->setMessageNotFound();
                return $basketAdapterService->response();
            }

            $basketAdapterService->calculateBasket($products);

            $basketAdapterService->setMessageSuccess();

            return $basketAdapterService->response();


        } catch (Exception $e) {

            $basketAdapterService->setMessageServerError();

            return $basketAdapterService->response();
        }

    }

}
