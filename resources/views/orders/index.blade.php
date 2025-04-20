@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Orders</h1>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">Create Order</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Send to Kitchen Time</th>
                    <th>Status</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->send_to_kitchen_time->format('Y-m-d H:i') }}</td>
                        <td>
                            <span class="badge
                                @if($order->status == 'pending') bg-warning
                                @elseif($order->status == 'in-progress') bg-primary
                                @else bg-success @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>LKR {{ number_format($order->total_price, 2) }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">View</a>
                            @if($order->status == 'pending')
                                <form action="{{ route('orders.send-to-kitchen', $order->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">Send to Kitchen</button>
                                </form>
                            @endif
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
