@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4 fw-bold text-center">Transactions Page</h2>

        <div class="row g-2">
            <div class="col-md-6 col-lg-6">
                <a href="{{ route('transactions.create') }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-receipt display-4 text-info mb-3"></i>
                            <h5 class="card-title">Cashier</h5>
                            <p class="card-text">Add new transactions</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-6">
                <a href="{{ route('transactions.history') }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-clock-history display-4 text-warning mb-3"></i>
                            <h5 class="card-title">History</h5>
                            <p class="card-text">See and manage cafe transactions.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
