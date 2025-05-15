@extends('layouts.master')
@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Product List</h2>
            <a href="{{ route('products.create') }}" class="btn btn-success btn-sm">+ Add Product</a>
        </div>
        @if ($products->count())
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
                @foreach ($products as $prod)
                    <div class="col">
                        <div class="card shadow-sm h-100 border-0 material-card">
                            @if ($prod->image_path)
                                <div class="position-relative card-img-container">
                                    <img src="{{ asset('storage/product_img/' . $prod->image_path) }}" class="card-img-top"
                                        alt="{{ $prod->name }}" style="height: 120px; object-fit: cover;">
                                    <div class="position-absolute top-0 end-0 p-1">
                                        <span class="badge {{ $prod->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                            {{ $prod->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="position-relative card-img-container bg-light">
                                    <div class="text-center py-4 card-img-top" style="height: 120px;">
                                        <i class="bi bi-box-seam text-muted"
                                            style="font-size: 2rem; line-height: 80px;"></i>
                                    </div>
                                    <div class="position-absolute top-0 end-0 p-1">
                                        <span class="badge {{ $prod->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                            {{ $prod->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                            <div class="card-body p-3">
                                <h6 class="card-title fw-bold text-truncate mb-1" title="{{ $prod->name }}">
                                    {{ $prod->name }}</h6>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Rp{{ number_format($prod->selling_price, 2) }}</small>
                                    <small>
                                        Stock: {{ number_format($prod->stock) }}
                                    </small>
                                </div>
                                @if ($prod->description)
                                    <p class="card-text small text-muted mb-2" style="height: 40px; overflow: hidden;">
                                        {{ Str::limit($prod->description, 50) }}
                                    </p>
                                @endif
                            </div>
                            <div class="card-footer bg-transparent p-2 border-0 d-flex justify-content-between">
                                <a href="{{ route('products.show', $prod->slug) }}"
                                    class="btn btn-sm btn-outline-primary px-2 py-1 btn-action">View</a>
                                <a href="{{ route('products.edit', $prod->slug) }}"
                                    class="btn btn-sm btn-outline-secondary px-2 py-1 btn-action">Edit</a>
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
            <div class="alert alert-info">No Products found.</div>
        @endif
    </div>
@endsection
