@extends('layouts.master')

@section('content')

<div class="container py-4"> <h2 class="fw-bold mb-4">Edit Supplier</h2>
    <form action="{{ route('suppliers.update', $supplier->slug) }}" method="POST">
        @csrf
        @method('PUT')

        @include('content.supplier.components.form', ['supplier' => $supplier])

        <div class="mt-4 d-flex justify-content-between">
            <div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('suppliers') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>

    <div class="mt-4 text-end">
        <form action="{{ route('suppliers.delete', $supplier->slug) }}" method="GET" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div> 
@endsection