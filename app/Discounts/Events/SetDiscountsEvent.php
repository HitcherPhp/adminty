<?php


namespace App\Discounts\Events;


use App\Discounts\Services\SetDiscountsAdapterService;
use App\Discounts\Services\SetDiscountsService;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SetDiscountsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SetDiscountsAdapterService $setDiscountsAdapter)
    {
        $this->setDiscountsAdapter = $setDiscountsAdapter;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('channel-name');
    }
}
