@extends('layouts.master')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Supplier Detail</h2>
            <div>
                <a href="{{ route('suppliers.edit', $supplier->slug) }}" class="btn btn-outline-primary me-2">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('suppliers') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-2">Name</h5>
                        <p>{{ $supplier->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-2">Contact Person</h5>
                        <p>{{ $supplier->contact_person }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-2">Phone</h5>
                        <p>{{ $supplier->phone }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-2">Email</h5>
                        <p>{{ $supplier->email }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <h5 class="fw-bold mb-2">Address</h5>
                    <p>{{ $supplier->address }}</p>
                </div>

                <div class="row mb-3">
                    @if ($supplier->city)
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-2">City</h5>
                            <p>{{ $supplier->city }}</p>
                        </div>
                    @endif
                    @if ($supplier->state)
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-2">State</h5>
                            <p>{{ $supplier->state }}</p>
                        </div>
                    @endif
                </div>

                <div class="row mb-3">
                    @if ($supplier->zip_code)
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-2">ZIP Code</h5>
                            <p>{{ $supplier->zip_code }}</p>
                        </div>
                    @endif
                    @if ($supplier->country)
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-2">Country</h5>
                            <p>{{ $supplier->country }}</p>
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <form action="{{ route('suppliers.delete', $supplier->slug) }}" method="GET"
                        onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                        <button type="submit" class="btn btn-outline-danger me-2">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
