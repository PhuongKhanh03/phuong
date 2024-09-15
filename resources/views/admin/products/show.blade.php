@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Product Details</h1>

    <!-- Display product details -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Name: {{ $product->name }}</h5>
            <p class="card-text"><strong>Quantity:</strong> {{ $product->quantity }}</p>
            <p class="card-text"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            <p class="card-text"><strong>Category:</strong> {{ optional($product->category)->name }}</p>
        </div>
    </div>

    <!-- Action buttons -->
    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning mb-2">Edit</a>

    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
    </form>

    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-2">Back to Product List</a>
</div>
@endsection
