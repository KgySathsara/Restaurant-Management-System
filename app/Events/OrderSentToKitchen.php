<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class OrderSentToKitchen
{
    use SerializesModels;

    public $orderId;

    /**
     * Create a new event instance.
     *
     * @param  int  $orderId
     * @return void
     */
    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }
}

