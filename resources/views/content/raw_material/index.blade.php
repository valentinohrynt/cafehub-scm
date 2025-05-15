@extends('layouts.master')
@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Raw Material List</h2>
            <a href="{{ route('raw_materials.create') }}" class="btn btn-success btn-sm">+ Add Raw Material</a>
        </div>
        @if ($rawMaterials->count())
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
                @foreach ($rawMaterials as $raw)
                    <div class="col">
                        <div class="card shadow-sm h-100 border-0 material-card">
                            @if ($raw->image_path)
                                <div class="position-relative card-img-container">
                                    <img src="{{ asset('storage/product_img/' . $raw->image_path) }}" class="card-img-top"
                                        alt="{{ $raw->name }}" style="height: 120px; object-fit: cover;">
                                    <div class="position-absolute top-0 end-0 p-1">
                                        <span class="badge {{ $raw->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                            {{ $raw->is_active ? 'Active' : 'Inactive' }}
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
                                        <span class="badge {{ $raw->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                            {{ $raw->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                            <div class="card-body p-3">
                                <h6 class="card-title fw-bold text-truncate mb-1" title="{{ $raw->name }}">
                                    {{ $raw->name }}</h6>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">${{ number_format($raw->unit_price, 2) }}</small>
                                    <small
                                        class="badge bg-{{ $raw->stock <= ($raw->reorder_level ?? 0) ? 'danger' : 'light text-dark' }}">
                                        Stock: {{ number_format($raw->stock) }}
                                    </small>
                                </div>
                                @if ($raw->description)
                                    <p class="card-text small text-muted mb-2" style="height: 40px; overflow: hidden;">
                                        {{ Str::limit($raw->description, 50) }}
                                    </p>
                                @endif
                            </div>
                            <div class="card-footer bg-transparent p-2 border-0 d-flex justify-content-between">
                                <a href="{{ route('raw_materials.show', $raw->slug) }}"
                                    class="btn btn-sm btn-outline-primary px-2 py-1 btn-action">View</a>
                                <a href="{{ route('raw_materials.edit', $raw->slug) }}"
                                    class="btn btn-sm btn-outline-secondary px-2 py-1 btn-action">Edit</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination links -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $rawMaterials->links() }}
            </div>
        @else
            <div class="alert alert-info">No Raw Materials found.</div>
        @endif
    </div>
@endsection
