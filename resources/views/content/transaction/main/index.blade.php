@extends('layouts.master')

@section('title', 'Transactions Hub')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Transaction Menu</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <a href="{{ route('transactions.create') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <i class="bi bi-receipt display-4 text-info mb-3"></i>
                        <h5 class="card-title">Cashier</h5>
                        <p class="card-text">Add new transactions</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('transactions.history') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <i class="bi bi-clock-history display-4 text-warning mb-3"></i>
                        <h5 class="card-title">Transaction History</h5>
                        <p class="card-text">View completed and past transactions.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    @include('content.transaction.main.components.list', ['ongoingTransactions' => $ongoingTransactions])

</div>
@endsection

@push('styles')
<style>
    .card-body.d-flex {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .badge.rounded-pill {
        padding: 0.4em 0.7em;
        font-size: 0.85em;
    }
</style>
@endpush