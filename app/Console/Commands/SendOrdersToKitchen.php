<?php

namespace App\Console\Commands;

use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendOrdersToKitchen extends Command
{
    protected $signature = 'orders:send-to-kitchen';
    protected $description = 'Automatically send pending orders to kitchen based on their scheduled time';

    public function __construct(private OrderRepositoryInterface $orderRepository)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $now = now();
        $this->info("Checking for orders to send to kitchen at {$now}");

        $pendingOrders = $this->orderRepository->getPendingOrders();

        if ($pendingOrders->isEmpty()) {
            $this->info('No pending orders found.');
            return Command::SUCCESS;
        }

        $sentCount = 0;

        foreach ($pendingOrders as $order) {
            if ($order->send_to_kitchen_time <= $now) {
                try {
                    $this->orderRepository->sendToKitchen($order->id);
                    $sentCount++;

                    $this->info("Sent order #{$order->id} to kitchen (scheduled for {$order->send_to_kitchen_time})");
                    Log::info("Automatically sent order to kitchen", [
                        'order_id' => $order->id,
                        'scheduled_time' => $order->send_to_kitchen_time,
                        'sent_at' => $now
                    ]);
                } catch (\Exception $e) {
                    Log::error("Failed to send order to kitchen", [
                        'order_id' => $order->id,
                        'error' => $e->getMessage()
                    ]);
                    $this->error("Failed to send order #{$order->id}: {$e->getMessage()}");
                }
            }
        }

        $this->info("Sent {$sentCount} orders to kitchen.");
        return Command::SUCCESS;
    }

}
