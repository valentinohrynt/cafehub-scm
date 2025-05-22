@extends('layouts.master')

@section('title', 'Detail Transaksi - ' . $transaction->code)

@section('content')
<div class="container py-4 py-lg-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h1 class="fw-bold text-primary mb-1">Detail Transaksi</h1>
            <p class="text-muted fs-5">Kode: <span class="fw-semibold">{{ $transaction->code }}</span></p>
        </div>
        <a href="{{ route('transactions') }}" class="btn btn-outline-secondary mt-2 mt-md-0">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Transaksi
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 py-1 fw-semibold"><i class="bi bi-info-circle-fill text-primary me-2"></i>Informasi Transaksi</h5>
                </div>
                <div class="card-body p-4">
                    @php
                        $transactionInfo = [
                            'Kode Transaksi' => $transaction->code,
                            'Tanggal Transaksi' => $transaction->created_at ? $transaction->created_at->translatedFormat('d M Y, H:i:s') : 'N/A', 
                            'Nama Pelanggan' => $transaction->customer_name ?: '-', 
                            'Nomor Meja' => $transaction->table_number ?: '-',
                            'Kasir' => $transaction->user->name ?? 'N/A',
                            'Metode Pembayaran' => Str::title(str_replace('_', ' ', $transaction->payment_method)),
                        ];
                    @endphp
                    <div class="row g-3">
                        @foreach ($transactionInfo as $label => $value)
                            <div class="col-md-6">
                                <div class="text-muted small mb-1">{{ $label }}</div>
                                <div class="fw-medium">{{ $value }}</div>
                            </div>
                        @endforeach

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Status Pembayaran</div>
                            <div>
                                @php
                                    $paymentStatusClass = $transaction->payment_status == 'paid' ? 'bg-success-subtle text-success-emphasis border border-success-subtle' : 'bg-warning-subtle text-warning-emphasis border border-warning-subtle';
                                    $paymentStatusIcon = $transaction->payment_status == 'paid' ? 'bi-check-circle-fill' : 'bi-clock-history';
                                @endphp
                                <span class="badge fs-6 rounded-pill px-3 py-2 {{ $paymentStatusClass }}">
                                    <i class="bi {{ $paymentStatusIcon }} me-1"></i>
                                    {{ ucfirst($transaction->payment_status) }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            @php
                                $statusConfig = [
                                    'in_progress' => ['class' => 'bg-info-subtle text-info-emphasis border border-info-subtle', 'icon' => 'bi-arrow-clockwise', 'label' => 'Dalam Proses'],
                                    'done' => ['class' => 'bg-success-subtle text-success-emphasis border border-success-subtle', 'icon' => 'bi-check-circle-fill', 'label' => 'Selesai'],
                                    'cancelled' => ['class' => 'bg-danger-subtle text-danger-emphasis border border-danger-subtle', 'icon' => 'bi-x-circle-fill', 'label' => 'Dibatalkan'],
                                ];
                                $currentStatus = $statusConfig[$transaction->status] ?? ['class' => 'bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle', 'icon' => 'bi-question-circle-fill', 'label' => Str::title(str_replace('_', ' ', $transaction->status))];
                            @endphp
                            <div class="text-muted small mb-1">Status Transaksi</div>
                            <div>
                                <span class="badge fs-6 rounded-pill px-3 py-2 {{ $currentStatus['class'] }}">
                                    <i class="bi {{ $currentStatus['icon'] }} me-1"></i>
                                    {{ $currentStatus['label'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 py-1 fw-semibold"><i class="bi bi-cart-check-fill text-success me-2"></i>Detail Item Dipesan</h5>
                </div>
                <div class="card-body p-0">
                    @if($transaction->transactionDetails->count())
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0" style="min-width: 600px;">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="ps-4">#</th>
                                        <th scope="col">Produk</th>
                                        <th scope="col" class="text-center">Jumlah</th>
                                        <th scope="col" class="text-end">Harga Satuan</th>
                                        <th scope="col" class="text-end pe-4">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaction->transactionDetails as $index => $detail)
                                    <tr>
                                        <td class="ps-4">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="fw-medium">{{ $detail->product->name ?? 'Produk Tidak Ditemukan' }}</div>
                                            @if(isset($detail->product->code))
                                            <small class="text-muted">Kode: {{ $detail->product->code }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $detail->quantity }}</td>
                                        <td class="text-end">Rp {{ number_format($detail->product->selling_price ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-end fw-semibold pe-4">Rp {{ number_format($detail->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="4" class="text-end fw-bold fs-5 py-3">Total Keseluruhan:</td>
                                        <td class="text-end text-success fw-bolder fs-5 py-3 pe-4">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="p-4 text-center">
                            <i class="bi bi-cart-x fs-1 text-muted mb-2 d-block"></i>
                            <p class="text-muted mb-0">Tidak ada item dalam transaksi ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary-subtle text-primary-emphasis border-bottom border-primary-subtle">
                    <h5 class="mb-0 py-1 fw-semibold"><i class="bi bi-cash-coin me-2"></i>Total Pembayaran</h5>
                </div>
                <div class="card-body text-center p-4">
                    <div class="fs-1 fw-bolder text-primary mb-2">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</div>
                    @if ($transaction->payment_status == 'paid')
                        <p class="text-success-emphasis mb-0"><i class="bi bi-patch-check-fill me-1"></i>Lunas</p>
                    @else
                        <p class="text-warning-emphasis mb-0"><i class="bi bi-hourglass-split me-1"></i>Menunggu Pembayaran</p>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 py-1 fw-semibold"><i class="bi bi-gear-fill text-secondary me-2"></i>Aksi</h5>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <button class="btn btn-info text-white" onclick="printReceipt()">
                            <i class="bi bi-printer-fill me-1"></i> Cetak Struk
                        </button>

                        @if($transaction->status == 'in_progress')
                            <form action="{{ route('transactions.updateStatus', $transaction->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menandai transaksi ini sebagai SELESAI?');">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="done">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-check-circle-fill me-1"></i> Tandai Selesai
                                </button>
                            </form>
                            <form action="{{ route('transactions.updateStatus', $transaction->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin MEMBATALKAN transaksi ini? Tindakan ini tidak dapat diurungkan.');">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="bi bi-x-circle-fill me-1"></i> Batalkan Transaksi
                                </button>
                            </form>
                        @elseif($transaction->status == 'done')
                             <p class="text-center text-muted mt-2 mb-0">Transaksi telah selesai.</p>
                        @elseif($transaction->status == 'cancelled')
                             <p class="text-center text-muted mt-2 mb-0">Transaksi telah dibatalkan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('content.transaction.main.components.receipt', ['detail' => $transaction])
</div>
@endsection

@push('styles')
<style>
    .table tfoot tr td, .table tfoot tr th {
        border-top-width: 2px; 
    }
    .badge.fs-6 {
        font-weight: 500; 
    }
    #printable-receipt {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
    function printReceipt() {
        const receiptElement = document.getElementById('printable-receipt');
        if (receiptElement) {
            receiptElement.style.display = 'block'; 
            
            const iframe = document.createElement('iframe');
            iframe.style.position = 'absolute';
            iframe.style.width = '0';
            iframe.style.height = '0';
            iframe.style.border = '0';
            document.body.appendChild(iframe);
            
            const doc = iframe.contentWindow.document;
            doc.open();
            doc.write('<html><head><title>Struk</title>');
            doc.write('<style>');
            doc.write(`
                body { font-family: 'Courier New', Courier, monospace; margin: 0; padding: 10px; color: #000; }
                .receipt-container { max-width: 320px; margin: 0 auto; font-size: 12px; }
                h3, h4 { text-align: center; margin-top: 5px; margin-bottom: 10px; }
                hr { border: 0; border-top: 1px dashed #000; margin: 10px 0; }
                .info p, .item-details div, .summary p { margin: 3px 0; }
                .info strong, .item-details strong, .summary strong { display: inline-block; min-width: 80px;}
                .item-table { width: 100%; border-collapse: collapse; margin: 10px 0; }
                .item-table th, .item-table td { text-align: left; padding: 2px 0; vertical-align: top;}
                .item-table th:nth-child(1), .item-table td:nth-child(1) { width: 60%; } /* Product Name */
                .item-table th:nth-child(2), .item-table td:nth-child(2) { text-align: right; width: 20%; } /* Qty x Price */
                .item-table th:nth-child(3), .item-table td:nth-child(3) { text-align: right; width: 20%; } /* Subtotal */
                .item-name { font-weight: bold; }
                .item-qty-price { font-size: 11px; }
                .text-right { text-align: right; }
                .total-line strong { font-size: 14px; }
                .thank-you { text-align: center; margin-top: 15px; }
            `);
            doc.write('</style></head><body>');
            doc.write(receiptElement.innerHTML);
            doc.write('</body></html>');
            doc.close();
            
            iframe.contentWindow.focus(); 
            iframe.contentWindow.print();
        

            setTimeout(() => {
                document.body.removeChild(iframe);
                receiptElement.style.display = 'none'; 
            }, 500);

        } else {
            console.error('Printable receipt element not found.');
        }
    }
</script>
@endpush