@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Concessions</h1>
        <a href="{{ route('concessions.create') }}" class="btn btn-primary">Add Concession</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($concessions as $concession)
                    <tr>
                        <td>{{ $concession->id }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $concession->image) }}" alt="{{ $concession->name }}" width="50">
                        </td>
                        <td>{{ $concession->name }}</td>
                        <td>LKR {{ number_format($concession->price, 2) }}</td>
                        <td>
                            <a href="{{ route('concessions.show', $concession->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('concessions.edit', $concession->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('concessions.destroy', $concession->id) }}" method="POST" style="display:inline;">
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
