<div class="card shadow-sm">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-list-ul me-2"></i>All Transactions
            </h5>
        </div>
        <div class="card-body">
            @if (isset($pastTransactions) && !$pastTransactions->isEmpty())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Customer</th>
                                <th>Table</th>
                                <th class="text-end">Total Amount</th>
                                <th class="text-center">Payment Status</th>
                                <th class="text-center">Order Status</th>
                                <th>Time</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pastTransactions as $transaction)
                                <tr>
                                    <td>
                                        <a href="{{ route('transactions.show', $transaction->id) }}"
                                            class="fw-bold text-decoration-none">{{ $transaction->code }}</a>
                                    </td>
                                    <td>{{ $transaction->customer_name ?: '-' }}</td>
                                    <td>{{ $transaction->table_number ?: '-' }}</td>
                                    <td class="text-end">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge rounded-pill px-3 py-2 {{ $transaction->payment_status == 'paid' ? 'bg-success-subtle text-success-emphasis border border-success-subtle' : 'bg-warning-subtle text-warning-emphasis border border-warning-subtle' }}">
                                            {{ Str::ucfirst($transaction->payment_status) }}
                                        </span>
                                    </td>
                                    @php
                                        $statusConfig = [
                                            'in_progress' => [
                                                'class' =>
                                                    'bg-info-subtle text-info-emphasis border border-info-subtle',
                                                'label' => 'Dalam Proses',
                                            ],
                                            'done' => [
                                                'class' =>
                                                    'bg-success-subtle text-success-emphasis border border-success-subtle',
                                                'label' => 'Selesai',
                                            ],
                                            'cancelled' => [
                                                'class' =>
                                                    'bg-danger-subtle text-danger-emphasis border border-danger-subtle',
                                                'label' => 'Dibatalkan',
                                            ],
                                        ];
                                        $currentStatus = $statusConfig[$transaction->status] ?? [
                                            'class' =>
                                                'bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle',
                                            'label' => Str::title(str_replace('_', ' ', $transaction->status)),
                                        ];
                                    @endphp
                                    <td class="text-center">
                                        <span class="badge rounded-pill px-3 py-2 {{ $currentStatus['class'] }}">
                                            {{ $currentStatus['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $transaction->created_at->format('d M Y, H:i') }}
                                        <small
                                            class="text-muted d-block">({{ $transaction->created_at->diffForHumans(null, true) }}
                                            ago)</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('transactions.show', $transaction->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="View Details">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        {{-- You could add other actions like re-print receipt, etc. --}}
                                        {{-- Example:
                                        <button onclick="printReceipt('{{ $transaction->id }}')" class="btn btn-sm btn-outline-secondary ms-1" title="Print Receipt">
                                            <i class="bi bi-printer-fill"></i>
                                        </button>
                                        --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                <div class="mt-4 d-flex justify-content-center">
                    {{ $pastTransactions->links() }}
                </div>

            @else
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle-fill me-2"></i>No transaction history found.
                </div>
            @endif
        </div>
    </div>