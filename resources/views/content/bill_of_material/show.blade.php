@extends('layouts.master')
@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Bill of Materials</h2>
            <a href="{{ route('bill_of_materials') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        @php
            $product = $billOfMaterials->first()->product ?? null;
        @endphp

        @if ($product)
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
                                    <h5 class="text-primary mb-0">Base Price: Rp{{ number_format($base_price, 2) }}</h5>
                                    <span class="text-muted">per unit</span>
                                </div>
                            </div>

                            <h5 class="fw-bold mb-3">Raw Materials</h5>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($billOfMaterials as $index => $bom)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $bom->rawMaterial->name ?? '-' }}</td>
                                                <td>{{ $bom->quantity }}</td>
                                                <td>Rp{{ number_format($bom->rawMaterial->unit_price ?? 0, 2) }}</td>
                                                <td>Rp{{ number_format($bom->total_cost, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('bill_of_materials.edit', $product->slug) }}"
                                    class="btn btn-outline-primary me-2">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('bill_of_materials.delete', $product->slug) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this BoM?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Product Info</h5>
                            <div class="mb-3">
                                <small class="text-muted d-block">Category</small>
                                <span class="fw-semibold">{{ $product->category->name ?? 'N/A' }}</span>
                            </div>
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
        @else
            <div class="alert alert-warning">
                Product not found or Bill of Materials is empty.
            </div>
        @endif
    </div>
@endsection
