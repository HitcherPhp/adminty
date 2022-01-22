<?php


namespace App\Discounts\Listeners;


use App\Discounts\Events\SetDiscountsEvent;
use App\Discounts\Models\DiscountModel;
use App\Discounts\Services\SetDiscountsService;

class SetDiscountsSubscriber
{

    public function handle_archive_old_discounts($event) {

        $setDiscounts = new SetDiscountsService();

        $setDiscounts->archive_old_discounts($event->setDiscountsAdapter);

        return $event->setDiscountsAdapter->getMessage();

    }

    public function handle_unset_discounts($event) {

        $setDiscounts = new SetDiscountsService();

        $setDiscounts->unset_discounts($event->setDiscountsAdapter);

        return $event->setDiscountsAdapter->getMessage();

    }

    public function handle_set_discounts($event) {

        $setDiscounts = new SetDiscountsService();

        $setDiscounts->set_discounts($event->setDiscountsAdapter);

        return $event->setDiscountsAdapter->getMessage();

    }


    public function subscribe($events)
    {

        $events->listen(
            'App\Discounts\Events\SetDiscountsEvent',
            'App\Discounts\Listeners\SetDiscountsSubscriber@handle_archive_old_discounts'
        );

        $events->listen(
            'App\Discounts\Events\SetDiscountsEvent',
            'App\Discounts\Listeners\SetDiscountsSubscriber@handle_unset_discounts'
        );

        $events->listen(
            'App\Discounts\Events\SetDiscountsEvent',
            'App\Discounts\Listeners\SetDiscountsSubscriber@handle_set_discounts'
        );

    }
}
