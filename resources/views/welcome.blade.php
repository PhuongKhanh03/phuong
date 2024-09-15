@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Welcome to Our Store</h1>

        <div class="card-deck">
            @foreach ($products as $product)
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text">Quantity: {{ $product->quantity }}</p>
                    <p class="card-text">Price: {{ number_format($product->price, 2) }}</p>
                    <p class="card-text">Category: {{ optional($product->category)->name }}</p>
                    <a href="{{ route('admin.products.show', $product->id) }}"
                    class="btn btn-primary">View Details</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
@endsection