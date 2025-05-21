@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Add New Transaction</h2>
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="customer_name" class="form-label">Customer Name</label>
                <input type="text" name="customer_name" id="customer_name" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="table_number" class="form-label">Table Number</label>
                <input type="text" name="table_number" id="table_number" class="form-control" required>
            </div>
        </div>


        <h5>Products</h5>
        <div id="product-list">
            <div class="product-item row mb-3">
                <div class="col-md-5">
                    <select name="products[0][product_id]" class="form-control product-select" required>
                        <option value="">-- Select Product --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"
                                data-price="{{ $product->selling_price }}">
                                {{ $product->name }} - Rp{{ number_format($product->selling_price, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="products[0][quantity]" class="form-control quantity-input" min="1" value="1" required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control price-display" readonly>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-product">X</button>
                </div>
            </div>
        </div>

        <button type="button" id="add-product" class="btn btn-primary mb-3">Add Product</button>

        <div class="mb-3">
            <label for="total_price" class="form-label">Total Price</label>
            <input type="text" id="total_price" name="total_price" class="form-control" readonly>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="">-- Select Payment Method --</option>
                    <option value="cash">Cash</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="debit_card">Debit Card</option>
                    <option value="qris">QRIS</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="payment_status" class="form-label">Payment Status</label>
                <select name="payment_status" id="payment_status" class="form-control" required>
                    <option value="">-- Select Payment Status --</option>
                    <option value="paid">Paid</option>
                    <option value="unpaid">Unpaid</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Submit Transaction</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let productIndex = 1;

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.product-item').forEach(function (row) {
            const select = row.querySelector('.product-select');
            const quantity = row.querySelector('.quantity-input');
            const priceDisplay = row.querySelector('.price-display');

            const price = parseFloat(select.selectedOptions[0]?.dataset.price || 0);
            const qty = parseInt(quantity.value) || 0;
            const subtotal = price * qty;

            priceDisplay.value = 'Rp' + subtotal.toFixed(2);
            total += subtotal;
        });
        document.getElementById('total_price').value = 'Rp' + total.toFixed(2);
    }

    document.getElementById('product-list').addEventListener('change', updateTotal);
    document.getElementById('product-list').addEventListener('input', updateTotal);

    document.getElementById('add-product').addEventListener('click', function () {
        const template = document.querySelector('.product-item');
        const clone = template.cloneNode(true);

        clone.querySelectorAll('select, input').forEach(input => {
            const name = input.name;
            if (name) {
                input.name = name.replace(/\d+/, productIndex);
            }
            if (input.classList.contains('price-display')) {
                input.value = '';
            } else if (input.classList.contains('quantity-input')) {
                input.value = 1;
            } else {
                input.value = '';
            }
        });

        productIndex++;
        document.getElementById('product-list').appendChild(clone);
        updateTotal();
    });

    document.getElementById('product-list').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-product')) {
            const row = e.target.closest('.product-item');
            if (document.querySelectorAll('.product-item').length > 1) {
                row.remove();
                updateTotal();
            }
        }
    });

    updateTotal();
});
</script>
@endsection
