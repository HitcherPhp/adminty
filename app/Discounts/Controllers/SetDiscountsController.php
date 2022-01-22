<?php


namespace App\Discounts\Controllers;


use App\Discounts\Events\SetDiscountsEvent;
use App\Discounts\Services\SetDiscountsAdapterService;

class SetDiscountsController
{

    public function __invoke()
    {
        $setDiscountsAdapter = new SetDiscountsAdapterService();

        $messages[] = $setDiscountsAdapter->getMessage();

        if (!$setDiscountsAdapter->hasNotFound() and !$setDiscountsAdapter->hasError()) {

            $events = event(new SetDiscountsEvent($setDiscountsAdapter));

            $messages = array_merge($messages, $events);
        }
        return $messages;
    }
}
