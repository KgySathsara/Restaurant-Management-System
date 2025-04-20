@extends('layouts.app')

@section('content')
    <h1>Create New Order</h1>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="concessions" class="form-label">Select Concessions</label>
            <select multiple class="form-select" id="concessions" name="concessions[]" required size="5">
                @foreach($concessions as $concession)
                    <option value="{{ $concession->id }}">{{ $concession->name }} - ${{ number_format($concession->price, 2) }}</option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl/Cmd to select multiple</small>
        </div>

        <div class="mb-3">
            <label for="send_to_kitchen_time" class="form-label">Send to Kitchen Time</label>
            <input type="datetime-local" class="form-control" id="send_to_kitchen_time" name="send_to_kitchen_time" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Order</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum datetime to now
        const now = new Date();
        const timezoneOffset = now.getTimezoneOffset() * 60000;
        const localISOTime = (new Date(now - timezoneOffset)).toISOString().slice(0, 16);
        document.getElementById('send_to_kitchen_time').min = localISOTime;
    });
</script>
@endpush
