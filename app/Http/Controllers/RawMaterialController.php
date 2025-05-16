<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\RawMaterial;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RawMaterialController extends Controller
{
    //
    public function index()
    {
        $rawMaterials = RawMaterial::paginate(50);

        return view('content.raw_material.index', compact('rawMaterials'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('content.raw_material.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'stock' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'image_path' => 'nullable|image',
            'reorder_level' => 'nullable|integer|min:0',
            'reorder_quantity' => 'nullable|integer|min:1',
            'lead_time' => 'nullable|integer|min:0',
            'safety_stock' => 'nullable|integer|min:0',
            'slug' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validatedData['code'] = strtoupper(Str::random(8));

        $rawMaterial = RawMaterial::create($validatedData);

        if ($request->hasFile('image_path')) {
            $imageName = handleProductImage($request->file('image_path'), $rawMaterial->code);
            if ($imageName) {
                $rawMaterial->update(['image_path' => $imageName]);
            }
        }

        return redirect()->route('raw_materials')->with('success', 'Raw Material created successfully.');
    }


    public function edit($slug)
    {
        $rawMaterial= RawMaterial::where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('content.raw_material.edit', compact('rawMaterial', 'categories', 'suppliers'));
    }

    public function update(Request $request, $slug)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'stock' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'image_path' => 'nullable|image',
            'reorder_level' => 'nullable|integer|min:0',
            'reorder_quantity' => 'nullable|integer|min:1',
            'lead_time' => 'nullable|integer|min:0',
            'safety_stock' => 'nullable|integer|min:0',
            'slug' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

$rawMaterial= RawMaterial::where('slug', $slug)->firstOrFail();
        $rawMaterial->update($validatedData);

        if ($request->hasFile('image_path')) {
            if ($rawMaterial->image_path && Storage::exists('public/product_img/' . $rawMaterial->image_path)) {
                Storage::delete('public/product_img/' . $rawMaterial->image_path);
            }

            $imageName = handleProductImage($request->file('image_path'), $rawMaterial->code);
            if ($imageName) {
                $rawMaterial->update(['image_path' => $imageName]);
            }
        }

        return redirect()->route('raw_materials')->with('success', 'Raw Material updated successfully.');
    }

    public function destroy($slug)
    {
        $rawMaterial= RawMaterial::where('slug', $slug)->firstOrFail();
        $rawMaterial->delete();

        return redirect()->route('raw_materials')->with('success', 'Raw Material deleted successfully.');
    }

    public function show($slug)
    {
        $rawMaterial= RawMaterial::where('slug', $slug)->firstOrFail();

        return view('content.raw_material.show', compact('rawMaterial'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $rawMaterials = RawMaterial::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(50);

        return view('content.raw_material.index', compact('rawMaterials'));
    }

    public function filter(Request $request)
    {
        $query = RawMaterial::query();

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->has('supplier_id')) {
            $query->where('supplier_id', $request->input('supplier_id'));
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->input('is_active'));
        }

        $rawMaterials = $query->paginate(50);

        return view('content.raw_material.index', compact('rawMaterials'));
    }

    public function toggleActive($slug)
    {
$rawMaterial= RawMaterial::where('slug', $slug)->firstOrFail();
        $rawMaterial->is_active = !$rawMaterial->is_active;
        $rawMaterial->save();

        return redirect()->route('raw_materials')->with('success', 'Raw Material status updated successfully.');
    }
}
