@php
    $isEdit = isset($rawMaterial);
    $route = $isEdit ? route('raw_materials.update', $rawMaterial->slug) : route('raw_materials.store');
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
                            value="{{ old('name', $isEdit ? $rawMaterial->name : '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="unit_price" class="form-label fw-bold">Unit Price <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="unit_price" id="unit_price" step="0.01" min="0"
                                class="form-control @error('unit_price') is-invalid @enderror"
                                value="{{ old('unit_price', $isEdit ? $rawMaterial->unit_price : '') }}" required>
                            @error('unit_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="stock" class="form-label fw-bold">Current Stock <span
                                class="text-danger">*</span></label>
                        <input type="number" name="stock" id="stock" min="0"
                            class="form-control @error('stock') is-invalid @enderror"
                            value="{{ old('stock', $isEdit ? $rawMaterial->stock : 0) }}" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="is_active" class="form-label fw-bold">Status</label>
                        <select name="is_active" id="is_active"
                            class="form-select @error('is_active') is-invalid @enderror">
                            <option value="1"
                                {{ old('is_active', $isEdit && $rawMaterial->is_active ? 1 : 0) == 1 ? 'selected' : '' }}>
                                Active</option>
                            <option value="0"
                                {{ old('is_active', $isEdit && $rawMaterial->is_active ? 1 : 0) == 0 ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="category_id" class="form-label fw-bold">Category <span
                                class="text-danger">*</span></label>
                        <select name="category_id" id="category_id"
                            class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $isEdit ? $rawMaterial->category_id : '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="supplier_id" class="form-label fw-bold">Supplier <span
                                class="text-danger">*</span></label>
                        <select name="supplier_id" id="supplier_id"
                            class="form-select @error('supplier_id') is-invalid @enderror" required>
                            <option value="">Select Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id', $isEdit ? $rawMaterial->supplier_id : '') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
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
                        @if ($isEdit && $rawMaterial->image_path)
                            <div class="mt-2">
                                <img src="{{ asset('storage/product_img/' . $rawMaterial->image_path) }}"
                                    alt="{{ $rawMaterial->name }}" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="description" class="form-label fw-bold">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $isEdit ? $rawMaterial->description : '') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <h5 class="mt-4 mb-3">Inventory Management Settings</h5>
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="reorder_level" class="form-label fw-bold">Reorder Level</label>
                        <input type="number" name="reorder_level" id="reorder_level" min="0"
                            class="form-control @error('reorder_level') is-invalid @enderror"
                            value="{{ old('reorder_level', $isEdit ? $rawMaterial->reorder_level : '') }}">
                        @error('reorder_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="reorder_quantity" class="form-label fw-bold">Reorder Quantity</label>
                        <input type="number" name="reorder_quantity" id="reorder_quantity" min="1"
                            class="form-control @error('reorder_quantity') is-invalid @enderror"
                            value="{{ old('reorder_quantity', $isEdit ? $rawMaterial->reorder_quantity : '') }}">
                        @error('reorder_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="lead_time" class="form-label fw-bold">Lead Time (days)</label>
                        <input type="number" name="lead_time" id="lead_time" min="0"
                            class="form-control @error('lead_time') is-invalid @enderror"
                            value="{{ old('lead_time', $isEdit ? $rawMaterial->lead_time : '') }}">
                        @error('lead_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="safety_stock" class="form-label fw-bold">Safety Stock</label>
                        <input type="number" name="safety_stock" id="safety_stock" min="0"
                            class="form-control @error('safety_stock') is-invalid @enderror"
                            value="{{ old('safety_stock', $isEdit ? $rawMaterial->safety_stock : '') }}">
                        @error('safety_stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('raw_materials') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update' : 'Create' }} Raw
                    Material</button>
            </div>
        </form>
    </div>
</div>
