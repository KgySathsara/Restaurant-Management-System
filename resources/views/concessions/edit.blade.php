@extends('layouts.app')

@section('content')
    <h1>Edit Concession</h1>

    <form action="{{ route('concessions.update', $concession->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $concession->name }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $concession->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Current Image</label>
            <img src="{{ asset('storage/' . $concession->image) }}" alt="{{ $concession->name }}" width="100" class="d-block mb-2">
            <input type="file" class="form-control" id="image" name="image">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $concession->price }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('concessions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
