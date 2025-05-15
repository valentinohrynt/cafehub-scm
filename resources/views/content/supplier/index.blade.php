@extends('layouts.master')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Supplier List</h2>
        <a href="{{ route('suppliers.create') }}" class="btn btn-success">+ Add Supplier</a>
    </div>

    @if ($suppliers->count())
        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $index => $supplier)
                        <tr>
                            <td>{{ $suppliers->firstItem() + $index }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->email }}</td>
                            <td>{{ Str::limit($supplier->address, 40) }}</td>
                            <td class="text-end">
                                <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination links -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $suppliers->links() }}
        </div>
    @else
        <div class="alert alert-info">No suppliers found.</div>
    @endif
</div>
@endsection
