@extends('layouts.master')
@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Raw Material Details</h2>
            <div>
                <a href="{{ route('products.edit', $product->slug) }}" class="btn btn-outline-primary me-2">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('products') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="row align-items-center mb-4">
                            <div class="col-md-8">
                                <h3 class="mb-1">{{ $product->name }}</h3>
                                <p class="text-muted mb-0">
                                    <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="ms-2">Code: <strong>{{ $product->code }}</strong></span>
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <h4 class="text-primary mb-0">Rp{{ number_format($product->selling_price, 2) }}</h4>
                                <span class="text-muted">per unit</span>
                            </div>
                        </div>

                        @if ($product->description)
                            <div class="mb-4">
                                <h5 class="fw-bold mb-2">Description</h5>
                                <p>{{ $product->description }}</p>
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="fw-bold mb-2">Category</h5>
                                <p>{{ $product->category->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <h5 class="fw-bold mb-2">Inventory Management</h5>
                        <div class="row g-3">
                            <div class="col-md-3 col-6">
                                <div class="card bg-light">
                                    <div class="card-body py-2 px-3">
                                        <small class="text-muted d-block">Current Stock</small>
                                        <span
                                            class="fw-bold {{ $product->stock <= ($product->reorder_level ?? 0) ? 'text-danger' : '' }}">
                                            {{ number_format($product->stock) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="card bg-light">
                                    <div class="card-body py-2 px-3">
                                        <small class="text-muted d-block">Base Price</small>
                                        <span class="fw-bold">{{ number_format($product->reorder_level ?? 0) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('products.delete', $product->slug) }}"
                                class="btn btn-outline-danger"
                                onclick="return confirm('Are you sure you want to delete this raw material?');">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Additional Information</h5>
                        <div class="mb-3">
                            <small class="text-muted d-block">Lead Time</small>
                            <span class="fw-semibold">{{ $product->lead_time ?? 'N/A' }} days</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Created At</small>
                            <span class="fw-semibold">{{ $product->created_at->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <small class="text-muted d-block">Last Updated</small>
                            <span class="fw-semibold">{{ $product->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                @if ($product->image_path)
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="fw-bold mb-3">Image</h5>
                            <img src="{{ asset('storage/product_img/' . $product->image_path) }}"
                                alt="{{ $product->name }}" class="img-fluid rounded">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
