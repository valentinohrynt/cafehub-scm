<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use App\Models\BillOfMaterial;


class BillOfMaterialController extends Controller
{
    //
    public function index()
    {
        $boms = BillOfMaterial::paginate(50);

        return view('content.bill_of_material.index', compact('boms'));
    }

    public function create()
    {
        $products = Product::all();
        $rawMaterials = RawMaterial::all();
        $suppliers = Supplier::all();

        return view('content.bill_of_material.create', compact('products', 'rawMaterials', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'raw_material_id' => 'required|exists:raw_materials,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
        ]);

        BillOfMaterial::create($validatedData);

        return redirect()->route('bill_of_material.index')->with('success', 'Bill of Material created successfully.');
    }

    public function edit($id)
    {
        $billOfMaterial = BillOfMaterial::findOrFail($id);
        $products = Product::all();
        $rawMaterials = RawMaterial::all();
        $suppliers = Supplier::all();

        return view('content.bill_of_material.edit', compact('billOfMaterial', 'products', 'rawMaterials', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'raw_material_id' => 'required|exists:raw_materials,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $billOfMaterial = BillOfMaterial::findOrFail($id);
        $billOfMaterial->update($validatedData);

        return redirect()->route('bill_of_material.index')->with('success', 'Bill of Material updated successfully.');
    }

    public function destroy($id)
    {
        $billOfMaterial = BillOfMaterial::findOrFail($id);
        $billOfMaterial->delete();

        return redirect()->route('bill_of_material.index')->with('success', 'Bill of Material deleted successfully.');
    }

    public function show($id)
    {
        $billOfMaterial = BillOfMaterial::findOrFail($id);

        return view('content.bill_of_material.show', compact('billOfMaterial'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $billsOfMaterial = BillOfMaterial::where('product_id', 'LIKE', "%{$query}%")
            ->orWhere('raw_material_id', 'LIKE', "%{$query}%")
            ->orWhere('supplier_id', 'LIKE', "%{$query}%")
            ->paginate(50);

        return view('content.bill_of_material.index', compact('billsOfMaterial'));
    }

    public function filter(Request $request)
    {
        $product_id = $request->input('product_id');
        $raw_material_id = $request->input('raw_material_id');
        $supplier_id = $request->input('supplier_id');

        $billsOfMaterial = BillOfMaterial::when($product_id, function ($query) use ($product_id) {
            return $query->where('product_id', $product_id);
        })
        ->when($raw_material_id, function ($query) use ($raw_material_id) {
            return $query->where('raw_material_id', $raw_material_id);
        })
        ->when($supplier_id, function ($query) use ($supplier_id) {
            return $query->where('supplier_id', $supplier_id);
        })
        ->paginate(50);

        return view('content.bill_of_material.index', compact('billsOfMaterial'));
    }
}
