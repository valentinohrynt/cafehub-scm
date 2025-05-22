<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::with(['billOfMaterial.rawMaterial'])->paginate(20);

        foreach ($products as $product) {
            $boms = $product->billOfMaterial;

            $product->base_price = $boms->sum('total_cost');

            $possibleUnits = PHP_INT_MAX;
            foreach ($boms as $bom) {
                $availableStock = $bom->rawMaterial->stock ?? 0;
                $requiredQty = $bom->quantity;
                if ($requiredQty > 0) {
                    $possibleUnits = min($possibleUnits, floor($availableStock / $requiredQty));
                }
            }
            $product->possible_units = $possibleUnits === PHP_INT_MAX ? 0 : $possibleUnits;
        }

        return view('content.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('type', 'product')->get();
        return view('content.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'selling_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image_path' => 'nullable|image',
            'slug' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validatedData['code'] = strtoupper(Str::random(8));

        $product = Product::create($validatedData);

        if ($request->hasFile('image_path')) {
            $imageName = handleProductImage($request->file('image_path'), $product->code);

            if ($imageName) {
                $product->update(['image_path' => $imageName]);
            }
        }

        return redirect()->route('products')->with('success', 'Product created successfully.');
    }

    public function edit($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $categories = Category::where('type', 'product')->get();

        return view('content.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $slug)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'selling_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image_path' => 'nullable|image',
            'slug' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $product = Product::where('slug', $slug)->firstOrFail();

        $product->update($validatedData);

        if ($request->hasFile('image_path')) {
            if ($product->image_path && Storage::exists('public/product_img/' . $product->image_path)) {
                Storage::delete('public/product_img/' . $product->image_path);
            }

            $imageName = handleProductImage($request->file('image_path'), $product->code);

            if ($imageName) {
                $product->update(['image_path' => $imageName]);
            }
        }

        return redirect()->route('products')->with('success', 'Product updated successfully.');
    }


    public function destroy($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $product->delete();

        return redirect()->route('products')->with('success', 'Product deleted successfully.');
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('content.product.show', compact('product'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(50);

        return view('content.product.index', compact('products'));
    }

    public function toggleActive($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $product->is_active = !$product->is_active;
        $product->save();

        return redirect()->route('products')->with('success', 'Product status updated successfully.');
    }

    public function filter(Request $request)
    {
        $query = Product::query();

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->input('is_active'));
        }

        $products = $query->paginate(50);

        return view('content.product.index', compact('products'));
    }
    
}
