<?php


namespace App\Basket\Interfaces;


interface BasketAdapterInterface
{

    public function setProductIds(array $product_ids): void;
    public function getProductIds(): array;

}
