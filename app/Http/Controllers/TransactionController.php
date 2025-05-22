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
        $ongoingTransactions = Transaction::where('status', 'in_progress')
                                         ->orderBy('created_at', 'desc')
                                         ->paginate(20);

        return view('content.transaction.main.index', compact('ongoingTransactions'));
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
            'payment_method' => 'required|string|in:cash,credit_card,bank_transfer,qris,debit_card',
            'payment_status' => 'required|string|in:unpaid,paid',
        ]);

        $cleanedTotal = preg_replace('/[^\d.]/', '', $request->total_price);

        $transaction = Transaction::create([
            'code' => 'TRX-' . strtoupper(Str::random(6)),
            'total_amount' => $cleanedTotal,
            'payment_method' => $validatedData['payment_method'], 
            'payment_status' => $validatedData['payment_status'],
            'user_id' => '1',
            'customer_name' => $validatedData['customer_name'], 
            'table_number' => $validatedData['table_number'],  
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

        return redirect()->route('transactions.show', $transaction->id)->with('success', 'Transaction created successfully!');
    }

    public function show($id) 
    {

        $transaction = Transaction::with(['transactionDetails.product', 'user'])->find($id);

        if (!$transaction) {
            abort(404, 'Transaksi dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('content.transaction.main.show', compact('transaction'));
    }


    public function updateStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'required|string|in:in_progress,cancelled,done',
        ]);

        $transaction->update(['status' => $validatedData['status']]);

        return redirect()->route('transactions')->with('success', 'Transaction status updated successfully.');
    }


    public function historyIndex()
    {
        $pastTransactions = Transaction::where('status','!=','in_progress')
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        return view('content.transaction.history.index', compact('pastTransactions'));
    }

    public function historyShow($id)
    {
        return view('content.transaction.history.show');
    }
}
