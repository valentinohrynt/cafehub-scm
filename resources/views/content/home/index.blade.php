@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4 fw-bold text-center">Welcome to CafeHub Management</h2>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('products') }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-cup-hot display-4 text-success mb-3"></i>
                            <h5 class="card-title">Products</h5>
                            <p class="card-text">Manage your cafe products like drinks, snacks, etc.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-3">
                <a href="{{ route('raw_materials') }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-box-seam display-4 text-warning mb-3"></i>
                            <h5 class="card-title">Raw Materials</h5>
                            <p class="card-text">Track and update your stock materials.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-3">
                <a href="{{ route('bill_of_materials') }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-clipboard-data display-4 text-info mb-3"></i>
                            <h5 class="card-title">Bill of Materials or Recipes</h5>
                            <p class="card-text">Define recipes and usage of raw materials.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-3">
                <a href="{{ route('suppliers') }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-truck display-4 text-danger mb-3"></i>
                            <h5 class="card-title">Suppliers</h5>
                            <p class="card-text">View and manage your raw material suppliers.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
