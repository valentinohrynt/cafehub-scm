@extends('layouts.master')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Add New Supplier</h2>

    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf

        @include('content.supplier.components.form', ['supplier' => null])

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('suppliers') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
