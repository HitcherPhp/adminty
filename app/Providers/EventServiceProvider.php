<?php

namespace App\Providers;

use App\Basket\Events\BasketListEvent;
use App\Basket\Listeners\BasketSubscriber;
use App\Models\CustomerModel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Discounts\Events\SetDiscountsEvent;
use App\Discounts\Listeners\SetDiscountsSubscriber;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ]
    ];


    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        'App\Discounts\Listeners\SetDiscountsSubscriber',
        'App\Basket\Listeners\BasketSubscriber',
    ];


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

    }

    protected function discoverEventsWithin()
    {
        return [
            $this->app->path('Listeners'),
            $this->app->path('Discounts\Listeners'),
            $this->app->path('Basket\Listeners')
        ];
    }
}
