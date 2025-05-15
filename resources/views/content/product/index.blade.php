@extends('layouts.master')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Product List</h2>
        <a href="{{ route('products.create') }}" class="btn btn-success">+ Add Product</a>
    </div>

    @if ($products->count())
        <div class="row g-4">
            @foreach ($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body">
                            <h5 class="card-title mb-1">{{ $product->name }}</h5>
                            <p class="text-muted mb-2">Price: <strong>${{ number_format($product->price, 2) }}</strong></p>
                            <p class="small text-muted">{{ Str::limit($product->description, 100) }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination links -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @else
        <div class="alert alert-info">No products found.</div>
    @endif
</div>
@endsection
