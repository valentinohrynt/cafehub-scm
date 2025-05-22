<div id="printable-receipt">
    <div class="receipt-container"
        style="max-width: 380px; margin: 0 auto; font-family: 'Courier New', Courier, monospace; font-size: 12px; color: #000;">
        {{-- You can add a logo or shop name here --}}
        <h3 style="text-align:center; margin-top: 5px; margin-bottom: 5px;">{{-- Nama Toko Anda --}}</h3>
        <p style="text-align:center; margin:0; font-size: 11px;">{{-- Alamat Toko Anda --}}</p>
        <p style="text-align:center; margin:0 0 10px 0; font-size: 11px;">{{-- Telp: Nomor Telepon Anda --}}</p>

        <h4 style="text-align:center; margin-bottom: 10px; font-size: 14px;">STRUK PEMBAYARAN</h4>

        <hr style="border: 0; border-top: 1px dashed #000; margin: 5px 0;">

        <div class="info" style="font-size: 11px;">
            <p style="margin: 2px 0; display: flex; justify-content: space-between;">
                <span><strong>No. Struk:</strong></span>
                <span>{{ $detail->code }}</span>
            </p>
            <p style="margin: 2px 0; display: flex; justify-content: space-between;">
                <span><strong>Tanggal:</strong></span>
                <span>{{ $detail->created_at ? $detail->created_at->format('d/m/y H:i') : '-' }}</span>
            </p>
            <p style="margin: 2px 0; display: flex; justify-content: space-between;">
                <span><strong>Kasir:</strong></span>
                <span>{{ $detail->user->name ?? '-' }}</span>
            </p>
            <p style="margin: 2px 0; display: flex; justify-content: space-between;">
                <span><strong>Pelanggan:</strong></span>
                <span>{{ $detail->customer_name ?: 'Umum' }}</span>
            </p>
            @if ($detail->table_number)
                <p style="margin: 2px 0; display: flex; justify-content: space-between;">
                    <span><strong>Meja:</strong></span>
                    <span>{{ $detail->table_number }}</span>
                </p>
            @endif
        </div>

        <hr style="border: 0; border-top: 1px dashed #000; margin: 5px 0;">

        <div class="item-details">
            <table style="width: 100%; border-collapse: collapse; font-size: 11px;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 2px 0;">Item</th>
                        <th style="text-align: right; padding: 2px 0;">Qty</th>
                        <th style="text-align: right; padding: 2px 0;">Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($detail->transactionDetails as $item)
                        <tr>
                            <td colspan="3" style="padding: 1px 0; text-align: left;">
                                {{ $item->product->name ?? 'Produk Tidak Ditemukan' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 1px 0 2px 5px; text-align: left; font-size: 10px;">
                                @if ($item->product && $item->product->selling_price !== null)
                                    @ {{ number_format($item->product->selling_price, 0, ',', '.') }}
                                @else
                                    @ -
                                @endif
                            </td>
                            <td style="padding: 1px 0 2px 0; text-align: right;">
                                {{ $item->quantity }}
                            </td>
                            <td style="padding: 1px 0 2px 0; text-align: right;">
                                {{ number_format($item->quantity * ($item->product->selling_price ?? 0), 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <hr style="border: 0; border-top: 1px dashed #000; margin: 5px 0;">

        <div class="summary" style="font-size: 12px;">
            <p style="margin: 3px 0; display: flex; justify-content: space-between;">
                <span>Subtotal:</span>
                <span style="text-align: right;">Rp {{ number_format($detail->total_amount, 0, ',', '.') }}</span>
            </p>
            <p style="margin: 3px 0; display: flex; justify-content: space-between; font-weight: bold; font-size: 14px;"
                class="total-line">
                <span>TOTAL:</span>
                <span style="text-align: right;">Rp {{ number_format($detail->total_amount, 0, ',', '.') }}</span>
            </p>
            <p style="margin: 3px 0; display: flex; justify-content: space-between;">
                <span>Metode Bayar:</span>
                <span
                    style="text-align: right;">{{ Str::title(str_replace('_', ' ', $detail->payment_method)) }}</span>
            </p>
            <p style="margin: 3px 0; display: flex; justify-content: space-between;">
                <span>Status Bayar:</span>
                <span style="text-align: right; font-weight:bold;">{{ ucfirst($detail->payment_status) }}</span>
            </p>
        </div>

        <hr style="border: 0; border-top: 1px dashed #000; margin: 10px 0;">

        <p style="text-align:center; font-size: 11px; margin: 5px 0;">Terima kasih atas kunjungan Anda!</p>
        <p style="text-align:center; font-size: 11px; margin: 5px 0;">{{-- Follow us @socialmedia --}}</p>
    </div>
</div>

@php
    if (!isset($detail)) {
        class DetailMock
        {
            public $code = 'INV123456789';
            public $created_at;
            public $user;
            public $customer_name = 'John Doe';
            public $table_number = '5';
            public $transactionDetails;
            public $total_amount = 175000;
            public $payment_method = 'cash';
            public $payment_status = 'paid';

            public function __construct()
            {
                $this->created_at = now();
                $this->user = (object) ['name' => 'Admin Kasir'];

                $item1_product = (object) ['name' => 'Nasi Goreng Spesial Plus Telur Dadar', 'selling_price' => 25000];
                $item1 = (object) ['product' => $item1_product, 'quantity' => 2];

                $item2_product = (object) ['name' => 'Es Teh Manis', 'selling_price' => 5000];
                $item2 = (object) ['product' => $item2_product, 'quantity' => 3];

                $item3_product = (object) ['name' => 'Produk Tidak Ditemukan Contoh', 'selling_price' => null];
                $item3 = (object) ['product' => $item3_product, 'quantity' => 1];

                $this->transactionDetails = [$item1, $item2, $item3];

                $calculated_total = 0;
                foreach ($this->transactionDetails as $transactionDetail) {
                    $calculated_total +=
                        $transactionDetail->quantity * ($transactionDetail->product->selling_price ?? 0);
                }
                $this->total_amount = $calculated_total;
            }
        }
        class Str
        {
            public static function title($value)
            {
                return ucwords(str_replace('_', ' ', $value));
            }
        }
        function now()
        {
            return new DateTime();
        }
        function number_format($number, $decimals = 0, $dec_point = ',', $thousands_sep = '.')
        {
            return \number_format($number, $decimals, $dec_point, $thousands_sep);
        }
        function ucfirst($string)
        {
            return \ucfirst($string);
        }

        $detail = new DetailMock();
    }
@endphp
