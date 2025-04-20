<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Requests\StoreOrderRequest;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;

class OrderController extends Controller
{
    private $orderRepository;
    private $concessionRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ConcessionRepositoryInterface $concessionRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->concessionRepository = $concessionRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->all();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $concessions = $this->concessionRepository->all();
        return view('orders.create', compact('concessions'));
    }

    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();

        // Calculate total price
        $concessions = $this->concessionRepository->findMany($data['concessions']);
        $totalPrice = $concessions->sum('price');

        // Create order
        $order = $this->orderRepository->create([
            'send_to_kitchen_time' => Carbon::parse($data['send_to_kitchen_time']),
            'status' => 'pending',
            'total_price' => $totalPrice,
        ]);


        // Attach concessions
        $order->concessions()->attach($data['concessions']);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show($id)
    {
        $order = $this->orderRepository->find($id);
        return view('orders.show', compact('order'));
    }

    public function destroy($id)
    {
        $this->orderRepository->delete($id);
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }

     public function kitchen()
    {
        $inProgressOrders = $this->orderRepository->getInProgressOrders();
        $completedOrders = $this->orderRepository->getCompletedOrders();
        return view('kitchen.index', compact('inProgressOrders', 'completedOrders'));
    }

    public function sendToKitchen($id)
    {
        $order = $this->orderRepository->sendToKitchen($id);
        return redirect()->back()->with('success', 'Order sent to kitchen.');
    }

    public function completeOrder($id)
    {
        $order = $this->orderRepository->completeOrder($id);
        return redirect()->back()->with('success', 'Order marked as completed.');
    }
}
