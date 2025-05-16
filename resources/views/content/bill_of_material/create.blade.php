@extends('layouts.master')

@section('content')

<div class="container py-4"> <div class="d-flex justify-content-between align-items-center mb-4"> <h2 class="fw-bold mb-0">Add New Product</h2> <a href="{{ route('products') }}" class="btn btn-outline-secondary"> <i class="bi bi-arrow-left"></i> Back to List </a> </div>
<div class="row">
    <div class="col-lg-12">
        @include('content.bill_of_material.components.form')
    </div>
</div>
</div> @endsection