@extends('layouts.master')

@section('content')

<div class="container py-4"> <div class="d-flex justify-content-between align-items-center mb-4"> <h2 class="fw-bold mb-0">Supplier Detail</h2> <a href="{{ route('suppliers.edit', $supplier->slug) }}" class="btn btn-sm btn-outline-primary">Edit</a> </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Name</dt>
                <dd class="col-sm-9">{{ $supplier->name }}</dd>

                <dt class="col-sm-3">Contact Person</dt>
                <dd class="col-sm-9">{{ $supplier->contact_person }}</dd>

                <dt class="col-sm-3">Phone</dt>
                <dd class="col-sm-9">{{ $supplier->phone }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $supplier->email }}</dd>

                <dt class="col-sm-3">Address</dt>
                <dd class="col-sm-9">{{ $supplier->address }}</dd>

                @if ($supplier->city)
                    <dt class="col-sm-3">City</dt>
                    <dd class="col-sm-9">{{ $supplier->city }}</dd>
                @endif

                @if ($supplier->state)
                    <dt class="col-sm-3">State</dt>
                    <dd class="col-sm-9">{{ $supplier->state }}</dd>
                @endif

                @if ($supplier->zip_code)
                    <dt class="col-sm-3">ZIP Code</dt>
                    <dd class="col-sm-9">{{ $supplier->zip_code }}</dd>
                @endif

                @if ($supplier->country)
                    <dt class="col-sm-3">Country</dt>
                    <dd class="col-sm-9">{{ $supplier->country }}</dd>
                @endif
            </dl>

            <div class="mt-4">
                <form action="{{ route('suppliers.delete', $supplier->slug) }}" method="GET" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                    <button type="submit" class="btn btn-danger">Delete Supplier</button>
                    <a href="{{ route('suppliers') }}" class="btn btn-secondary">Back to List</a>
                </form>
            </div>
        </div>
    </div>
</div> 
@endsection