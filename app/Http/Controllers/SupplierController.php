<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    //
    public function index()
    {
        $suppliers = Supplier::paginate(50);

        return view('content.supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('content.supplier.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
        ]);

        Supplier::create($validatedData);

        return redirect()->route('suppliers')->with('success', 'Supplier created successfully.');
    }

    public function edit($slug)
    {
        $supplier = Supplier::where('slug', $slug)->firstOrFail();

        return view('content.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $slug)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $supplier = Supplier::where('slug', $slug)->firstOrFail();
        $supplier->update($validatedData);

        return redirect()->route('suppliers')->with('success', 'Supplier updated successfully.');
    }

    public function destroy($slug)
    {
        $supplier = Supplier::where('slug', $slug)->firstOrFail();
        $supplier->delete();

        return redirect()->route('suppliers')->with('success', 'Supplier deleted successfully.');
    }

    public function show($slug)
    {
        $supplier = Supplier::where('slug', $slug)->firstOrFail();
        return view('content.supplier.show', compact('supplier'));
    }


    public function search(Request $request)
    {
        $query = $request->input('query');
        $suppliers = Supplier::where('name', 'LIKE', "%{$query}%")
            ->orWhere('contact_person', 'LIKE', "%{$query}%")
            ->orWhere('phone', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('address', 'LIKE', "%{$query}%")
            ->paginate(50);

        return view('content.supplier.index', compact('suppliers'));
    }

    public function filter(Request $request)
    {
        $filters = $request->only(['name', 'contact_person', 'phone', 'email', 'address']);
        $suppliers = Supplier::query();

        foreach ($filters as $key => $value) {
            if ($value) {
                $suppliers->where($key, 'LIKE', "%{$value}%");
            }
        }

        $suppliers = $suppliers->paginate(50);

        return view('content.supplier.index', compact('suppliers'));
    }
}
