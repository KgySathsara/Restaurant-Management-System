@extends('layouts.app')

@section('content')
    <h1>Kitchen Dashboard</h1>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3>In Progress Orders</h3>
                </div>
                <div class="card-body">
                    @if($inProgressOrders->isEmpty())
                        <p>No orders in progress</p>
                    @else
                        <div class="list-group">
                            @foreach($inProgressOrders as $order)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5>Order #{{ $order->id }}</h5>
                                            <p class="mb-1">Total: LKR {{ number_format($order->total_price, 2) }}</p>
                                            <small class="text-muted">Received at: {{ $order->updated_at->format('H:i') }}</small>
                                        </div>
                                        <form action="{{ route('orders.complete', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Complete</button>
                                        </form>
                                    </div>
                                    <div class="mt-2">
                                        <h6>Items:</h6>
                                        <ul>
                                            @foreach($order->concessions as $concession)
                                                <li>{{ $concession->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3>Completed Orders</h3>
                </div>
                <div class="card-body">
                    @if($completedOrders->isEmpty())
                        <p>No completed orders</p>
                    @else
                        <div class="list-group">
                            @foreach($completedOrders as $order)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5>Order #{{ $order->id }}</h5>
                                            <p class="mb-1">Total: LKR {{ number_format($order->total_price, 2) }}</p>
                                            <small class="text-muted">Completed at: {{ $order->updated_at->format('H:i') }}</small>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <h6>Items:</h6>
                                        <ul>
                                            @foreach($order->concessions as $concession)
                                                <li>{{ $concession->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
