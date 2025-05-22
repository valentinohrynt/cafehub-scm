@extends('layouts.master') {{-- Assuming you have a layouts.master --}}

@section('title', 'Transaction History')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary mb-0">Transaction History</h1>
        <a href="{{ route('transactions') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Transaction Menu
        </a>
    </div>

    @include('content.transaction.history.components.list', [
        'pastTransactions' => $pastTransactions,
    ])
</div>
@endsection

@push('styles')
<style>
    .table th,
    .table td {
        vertical-align: middle;
    }
    .table th {
        white-space: nowrap;
    }
</style>
@endpush