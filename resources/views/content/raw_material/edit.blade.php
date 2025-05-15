@extends('layouts.master')
@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Edit Raw Material: {{ $rawMaterial->name }}</h2>
            <div>
                <a href="{{ route('raw_materials.show', $rawMaterial->slug) }}" class="btn btn-outline-primary me-2">
                    <i class="bi bi-eye"></i> View Details
                </a>
                <a href="{{ route('raw_materials') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @include('content.raw_material.components.form')
            </div>
        </div>
    </div>
@endsection
