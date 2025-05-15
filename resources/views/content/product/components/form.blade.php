@php
    $isEdit = isset($product);
    $route = $isEdit ? route('products.update', $product->slug) : route('products.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($isEdit)
                @method($method)
            @endif
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $isEdit ? $product->name : '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="selling_price" class="form-label fw-bold">Selling Price <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="selling_price" id="selling_price" step="0.01" min="0"
                                class="form-control @error('selling_price') is-invalid @enderror"
                                value="{{ old('selling_price', $isEdit ? $product->selling_price : '') }}" required>
                            @error('selling_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                {{-- <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="stock" class="form-label fw-bold">Current Stock <span
                                class="text-danger">*</span></label>
                        <input type="number" name="stock" id="stock" min="0"
                            class="form-control @error('stock') is-invalid @enderror"
                            value="{{ old('stock', $isEdit ? $product->stock : 0) }}" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div> --}}

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="is_active" class="form-label fw-bold">Status</label>
                        <select name="is_active" id="is_active"
                            class="form-select @error('is_active') is-invalid @enderror">
                            <option value="1"
                                {{ old('is_active', $isEdit && $product->is_active ? 1 : 0) == 1 ? 'selected' : '' }}>
                                Active</option>
                            <option value="0"
                                {{ old('is_active', $isEdit && $product->is_active ? 1 : 0) == 0 ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="category_id" class="form-label fw-bold">Category <span
                                class="text-danger">*</span></label>
                        <select name="category_id" id="category_id"
                            class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $isEdit ? $product->category_id : '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">

                {{-- <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="supplier_id" class="form-label fw-bold">Supplier <span
                                class="text-danger">*</span></label>
                        <select name="supplier_id" id="supplier_id"
                            class="form-select @error('supplier_id') is-invalid @enderror" required>
                            <option value="">Select Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id', $isEdit ? $product->supplier_id : '') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div> --}}
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="image_path" class="form-label fw-bold">Image</label>
                        <input type="file" name="image_path" id="image_path"
                            class="form-control @error('image_path') is-invalid @enderror" accept="image/*">
                        @error('image_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($isEdit && $product->image_path)
                            <div class="mt-2">
                                <img src="{{ asset('storage/product_img/' . $product->image_path) }}"
                                    alt="{{ $product->name }}" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="description" class="form-label fw-bold">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $isEdit ? $product->description : '') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('products') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update' : 'Create' }} Product</button>
            </div>
        </form>
    </div>
</div>
