@extends('layouts.master')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Bill of Materials List</h2>
            <a href="{{ route('bill_of_materials.create') }}" class="btn btn-success">+ Add BOM</a>
        </div>

        @if ($billOfMaterials->count())
            <div class="row g-4">
                @foreach ($billOfMaterials as $bom)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100 border-0">
                            <div class="card-body">
                                <h5 class="card-title mb-1">{{ $bom->product->name }}</h5>
                                <p class="text-muted mb-2">Base price:
                                    <strong>Rp{{ number_format($bom->base_price, 2) }}</strong></p>
                            </div>
                            <div
                                class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
                                <a href="{{ route('bill_of_materials.show', $bom->product->slug) }}"
                                    class="btn btn-sm btn-outline-primary">View</a>
                                <a href="{{ route('bill_of_materials.edit', $bom->product->slug) }}"
                                    class="btn btn-sm btn-outline-secondary">Edit</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination links -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $billOfMaterials->links() }}
            </div>
        @else
            <div class="alert alert-info">No Bill of Materials found.</div>
        @endif
    </div>
@endsection
