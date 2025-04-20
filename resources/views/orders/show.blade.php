@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2>Order #{{ $order->id }}</h2>

            <div class="mb-3">
                <strong>Status:</strong>
                <span class="badge
                    @if($order->status == 'pending') bg-warning
                    @elseif($order->status == 'in-progress') bg-primary
                    @else bg-success @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="mb-3">
                <strong>Send to Kitchen Time:</strong> {{ $order->send_to_kitchen_time->format('Y-m-d H:i') }}
            </div>

            <div class="mb-3">
                <strong>Total Price:</strong> LKR {{ number_format($order->total_price, 2) }}
            </div>

            <h4 class="mt-4">Concessions</h4>
            <ul class="list-group">
                @foreach($order->concessions as $concession)
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5>{{ $concession->name }}</h5>
                                <p class="mb-0">LKR {{ number_format($concession->price, 2) }}</p>
                            </div>
                            <img src="{{ asset('storage/' . $concession->image) }}" alt="{{ $concession->name }}" width="50">
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                @if($order->status == 'pending')
                    <form action="{{ route('orders.send-to-kitchen', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Send to Kitchen</button>
                    </form>
                @endif
                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
