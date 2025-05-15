<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::paginate(50);

        return view('content.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('content.product.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'base_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image_path' => 'nullable|image|max:2048',
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

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('content.product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'base_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image_path' => 'nullable|image|max:2048',
            'slug' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $product = Product::findOrFail($id);

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

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

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

    public function toggleActive($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product status updated successfully.');
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
