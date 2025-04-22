<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
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
        Log::info('Accessing order index page');
        $orders = $this->orderRepository->all();
        Log::debug('Retrieved orders count: ' . $orders->count());
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        Log::info('Accessing order creation page');
        $concessions = $this->concessionRepository->all();
        Log::debug('Retrieved concessions count: ' . $concessions->count());
        return view('orders.create', compact('concessions'));
    }

    public function store(StoreOrderRequest $request)
    {
        Log::info('Starting order creation process');
        $data = $request->validated();
        Log::debug('Order data validated', ['data' => $data]);

        // Calculate total price
        $concessions = $this->concessionRepository->findMany($data['concessions']);
        $totalPrice = $concessions->sum('price');
        Log::debug('Calculated total price', ['total_price' => $totalPrice]);

        // Create order
        $order = $this->orderRepository->create([
            'send_to_kitchen_time' => Carbon::parse($data['send_to_kitchen_time']),
            'status' => 'pending',
            'total_price' => $totalPrice,
        ]);
        Log::info('Order created', ['order_id' => $order->id]);

        // Attach concessions
        $order->concessions()->attach($data['concessions']);
        Log::debug('Concessions attached to order', [
            'order_id' => $order->id,
            'concession_ids' => $data['concessions']
        ]);

        Log::info('Order creation completed successfully', ['order_id' => $order->id]);
        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show($id)
    {
        Log::info('Accessing order details', ['order_id' => $id]);
        $order = $this->orderRepository->find($id);
        Log::debug('Retrieved order details', ['order' => $order]);
        return view('orders.show', compact('order'));
    }

    public function destroy($id)
    {
        Log::info('Attempting to delete order', ['order_id' => $id]);
        $this->orderRepository->delete($id);
        Log::info('Order deleted successfully', ['order_id' => $id]);
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }

    public function kitchen()
    {
        Log::info('Accessing kitchen orders view');
        $inProgressOrders = $this->orderRepository->getInProgressOrders();
        $completedOrders = $this->orderRepository->getCompletedOrders();
        Log::debug('Kitchen orders retrieved', [
            'in_progress_count' => $inProgressOrders->count(),
            'completed_count' => $completedOrders->count()
        ]);
        return view('kitchen.index', compact('inProgressOrders', 'completedOrders'));
    }

    public function sendToKitchen($id)
    {
        Log::info('Sending order to kitchen', ['order_id' => $id]);
        $order = $this->orderRepository->sendToKitchen($id);
        Log::info('Order sent to kitchen successfully', ['order_id' => $id]);
        return redirect()->back()->with('success', 'Order sent to kitchen.');
    }

    public function completeOrder($id)
    {
        Log::info('Marking order as completed', ['order_id' => $id]);
        $order = $this->orderRepository->completeOrder($id);
        Log::info('Order marked as completed', ['order_id' => $id]);
        return redirect()->back()->with('success', 'Order marked as completed.');
    }
}
