<?php

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getPendingOrders();
    public function getInProgressOrders();
    public function getCompletedOrders();
    public function sendToKitchen($orderId);
    public function completeOrder($orderId);
}
