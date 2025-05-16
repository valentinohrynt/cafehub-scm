<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use App\Models\BillOfMaterial;

class BillOfMaterialController extends Controller
{
    public function index()
    {
        // Ambil daftar produk yang punya BOM, paginasi 50
        $billOfMaterials = BillOfMaterial::select('product_id')
            ->with('product')
            ->groupBy('product_id')
            ->paginate(50);

        foreach ($billOfMaterials as $bomGroup) {
            $details = BillOfMaterial::where('product_id', $bomGroup->product_id)->get();

            $bomGroup->base_price = $details->sum('total_cost');

            $possibleUnits = PHP_INT_MAX;
            foreach ($details as $detail) {
                $available = $detail->rawMaterial->stock ?? 0;
                $required = $detail->quantity;
                if ($required > 0) {
                    $possibleUnits = min($possibleUnits, floor($available / $required));
                }
            }
            $bomGroup->possible_units = $possibleUnits === PHP_INT_MAX ? 0 : $possibleUnits;
        }

        return view('content.bill_of_material.index', compact('billOfMaterials'));
    }

    public function create()
    {
        $products = Product::all();
        $rawMaterials = RawMaterial::all();
        $suppliers = Supplier::all();

        return view('content.bill_of_material.create', compact('products', 'rawMaterials'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'raw_materials' => 'required|array|min:1',
            'raw_materials.*' => 'required|exists:raw_materials,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'required|integer|min:1',
        ]);

        BillOfMaterial::where('product_id', $validatedData['product_id'])->delete();

        foreach ($validatedData['raw_materials'] as $index => $rawMaterialId) {
            $quantity = $validatedData['quantities'][$index];
            $unitPrice = RawMaterial::findOrFail($rawMaterialId)->unit_price;

            BillOfMaterial::create([
                'product_id' => $validatedData['product_id'],
                'raw_material_id' => $rawMaterialId,
                'quantity' => $quantity,
                'total_cost' => $unitPrice * $quantity,
                'is_active' => true,
            ]);
        }

        return redirect()->route('bill_of_materials')->with('success', 'Bill of Material created successfully.');
    }

    public function edit($productSlug)
    {
        $product = Product::where('slug', $productSlug)->firstOrFail();

        $billOfMaterial = BillOfMaterial::with('rawMaterial')
            ->where('product_id', $product->id)
            ->get();

        $products = Product::all();
        $rawMaterials = RawMaterial::all();

        return view('content.bill_of_material.edit', compact('billOfMaterial', 'product', 'products', 'rawMaterials'));
    }

    public function update(Request $request, $productSlug)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'raw_materials' => 'required|array|min:1',
            'raw_materials.*' => 'required|exists:raw_materials,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validatedData['product_id']);

        // Hapus semua BOM bahan baku lama untuk produk ini
        BillOfMaterial::where('product_id', $product->id)->delete();

        foreach ($validatedData['raw_materials'] as $index => $rawMaterialId) {
            $quantity = $validatedData['quantities'][$index];
            $unitPrice = RawMaterial::findOrFail($rawMaterialId)->unit_price;

            BillOfMaterial::create([
                'product_id' => $product->id,
                'raw_material_id' => $rawMaterialId,
                'quantity' => $quantity,
                'total_cost' => $unitPrice * $quantity,
                'is_active' => true,
            ]);
        }

        return redirect()->route('bill_of_materials')->with('success', 'Bill of Material updated successfully.');
    }

    public function destroy($productSlug)
    {
        $product = Product::where('slug', $productSlug)->firstOrFail();

        BillOfMaterial::where('product_id', $product->id)->delete();

        return redirect()->route('bill_of_materials')->with('success', 'Bill of Material deleted successfully.');
    }

    public function show($productSlug)
    {
        $product = Product::where('slug', $productSlug)->firstOrFail();

        $billOfMaterials = BillOfMaterial::where('product_id', $product->id)
            ->with(['rawMaterial', 'product'])
            ->get();

        if ($billOfMaterials->isEmpty()) {
            abort(404);
        }

        $base_price = $billOfMaterials->sum('total_cost');

        return view('content.bill_of_material.show', compact('billOfMaterials', 'base_price'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $billOfMaterials = BillOfMaterial::with('product')
            ->whereHas('product', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->groupBy('product_id')
            ->paginate(50);

        return view('content.bill_of_material.index', compact('billOfMaterials'));
    }

    public function filter(Request $request)
    {
        $product_id = $request->input('product_id');
        $raw_material_id = $request->input('raw_material_id');
        $supplier_id = $request->input('supplier_id');

        $billOfMaterials = BillOfMaterial::when($product_id, fn($q) => $q->where('product_id', $product_id))
            ->when($raw_material_id, fn($q) => $q->where('raw_material_id', $raw_material_id))
            ->when($supplier_id, fn($q) => $q->where('supplier_id', $supplier_id))
            ->groupBy('product_id')
            ->paginate(50);

        return view('content.bill_of_material.index', compact('billOfMaterials'));
    }
}
