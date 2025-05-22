<div class="mt-5">
    <h3 class="mb-3 fw-semibold">Ongoing Transactions</h3>
    @if (isset($ongoingTransactions) && !$ongoingTransactions->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Customer</th>
                                <th>Table</th>
                                <th class="text-end">Total Amount</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Time</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ongoingTransactions as $transaction)
                                <tr>
                                    <td>
                                        <a href="{{ route('transactions.show', $transaction->id) }}"
                                            class="fw-bold text-decoration-none">{{ $transaction->code }}</a>
                                    </td>
                                    <td>{{ $transaction->customer_name }}</td>
                                    <td>{{ $transaction->table_number }}</td>
                                    <td class="text-end">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <span
                                            class="rounded-pill px-3 py-2 {{ $transaction->payment_status == 'paid' ? 'bg-success-subtle text-success-emphasis' : 'bg-warning-subtle text-warning-emphasis' }}">
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
                                    <td>
                                        <span class="rounded-pill px-3 py-2 {{ $currentStatus['class'] }}">
                                            {{ $currentStatus['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $transaction->created_at->format('H:i') }}
                                        <small
                                            class="text-muted d-block">({{ $transaction->created_at->diffForHumans(null, true) }}
                                            ago)</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('transactions.show', $transaction->id) }}"
                                            class="btn btn-sm btn-outline-primary me-1" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if ($transaction->status == 'in_progress')
                                            <form action="{{ route('transactions.updateStatus', $transaction->id) }}"
                                                method="POST" style="display:inline;"
                                                onsubmit="return confirm('Mark this transaction as DONE?');">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="done">
                                                <button type="submit" class="btn btn-sm btn-outline-success"
                                                    title="Mark as Done">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            No ongoing transactions at the moment.
        </div>
    @endif
</div>
