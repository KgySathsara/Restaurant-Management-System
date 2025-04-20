@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('storage/' . $concession->image) }}" alt="{{ $concession->name }}" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <h2>{{ $concession->name }}</h2>
                    <p class="text-muted">LKR {{ number_format($concession->price, 2) }}</p>
                    <p>{{ $concession->description }}</p>

                    <div class="mt-4">
                        <a href="{{ route('concessions.edit', $concession->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('concessions.destroy', $concession->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        <a href="{{ route('concessions.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
