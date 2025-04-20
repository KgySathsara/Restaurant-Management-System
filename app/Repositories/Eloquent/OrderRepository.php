<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Carbon\Carbon;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function getPendingOrders()
    {
        return $this->model->where('status', 'pending')
            ->where('send_to_kitchen_time', '<=', now())
            ->with('concessions')
            ->get();
    }

    public function getInProgressOrders()
    {
        return $this->model->where('status', 'in-progress')->get();
    }

    public function getCompletedOrders()
    {
        return $this->model->where('status', 'completed')->get();
    }

    public function sendToKitchen($orderId)
    {
        $order = $this->find($orderId);
        $order->status = 'in-progress';
        $order->save();
        return $order;
    }

    public function completeOrder($orderId)
    {
        $order = $this->find($orderId);
        $order->status = 'completed';
        $order->save();
        return $order;
    }
}
