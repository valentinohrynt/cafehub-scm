<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;

class TransactionController extends Controller
{
    //

    public function index()
    {
        return view('content.transaction.main.index');
    }

    public function create()
    {
        $products = Product::where('is_active', 1)->get();
        return view('content.transaction.main.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number' => 'required|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'total_price' => 'required|string',
        ]);

        $cleanedTotal = preg_replace('/[^\d.]/', '', $request->total_price);

        $transaction = Transaction::create([
            'code' => 'TRX-' . strtoupper(Str::random(6)),
            'total_amount' => $cleanedTotal,
            'payment_method' => 'cash', 
            'payment_status' => 'unpaid',
            'status' => 'pending',
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name, 
            'table_number' => $request->table_number,  
        ]);

        foreach ($request->products as $item) {
            $product = Product::findOrFail($item['product_id']);
            $quantity = (int) $item['quantity'];
            $totalPrice = $product->selling_price * $quantity;

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }


    public function historyIndex()
    {
        return view('content.transaction.history.index');
    }

    public function historyShow()
    {
        return view('content.transaction.history.show');
    }

}
