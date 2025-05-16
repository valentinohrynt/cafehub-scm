@php
    $isEdit = isset($product);
    $route = $isEdit ? route('bill_of_materials.update', $product->slug) : route('bill_of_materials.store');
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
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="product_id" class="form-label fw-bold">Product Name <span
                                    class="text-danger">*</span></label>
                            <select name="product_id" id="product_id"
                                class="form-select @error('product_id') is-invalid @enderror" required>
                                <option value="">Select product</option>
                                @foreach ($products as $p)
                                    <option value="{{ $p->id }}"
                                        {{ old('product_id', $isEdit ? $product->id : '') == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Raw Materials <span class="text-danger">*</span></label>
                            <div id="raw-materials-wrapper">
                                @if ($isEdit)
                                    @foreach ($billOfMaterial as $material)
                                        <div class="input-group mb-2 raw-material-row">
                                            <select name="raw_materials[]" class="form-select me-2 raw-material-select"
                                                required>
                                                <option value="">Select raw material</option>
                                                @foreach ($rawMaterials as $rm)
                                                    <option value="{{ $rm->id }}"
                                                        data-price="{{ $rm->unit_price }}"
                                                        {{ $material->raw_material_id == $rm->id ? 'selected' : '' }}>
                                                        {{ $rm->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="number" name="quantities[]"
                                                class="form-control me-2 quantity-input" placeholder="Quantity"
                                                value="{{ old('quantities.' . $loop->index, $material->quantity) }}"
                                                required>
                                            <input type="text" class="form-control me-2 cost-output"
                                                placeholder="Cost" readonly>
                                            <button type="button"
                                                class="btn btn-danger remove-material">Remove</button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2 raw-material-row">
                                        <select name="raw_materials[]" class="form-select me-2 raw-material-select"
                                            required>
                                            <option value="">Select raw material</option>
                                            @foreach ($rawMaterials as $rm)
                                                <option value="{{ $rm->id }}"
                                                    data-price="{{ $rm->unit_price }}">{{ $rm->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="number" name="quantities[]"
                                            class="form-control me-2 quantity-input" placeholder="Quantity"
                                            value="1" required>
                                        <input type="text" class="form-control me-2 cost-output" placeholder="Cost"
                                            readonly>
                                        <button type="button" class="btn btn-danger remove-material">Remove</button>
                                    </div>
                                @endif

                            </div>
                            <p class="fw-bold mt-3">Total Cost: <span id="total-cost">0</span></p>

                            <button type="button" id="add-material" class="btn btn-success mt-2">Add Raw
                                Material</button>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('bill_of_materials') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update' : 'Create' }}
                        Bill Of Material</button>
                </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");
        const wrapper = document.getElementById('raw-materials-wrapper');
        const addButton = document.getElementById('add-material');
        const totalCostDisplay = document.getElementById('total-cost');

        function updateCosts() {
            let total = 0;
            wrapper.querySelectorAll('.raw-material-row').forEach(row => {
                const select = row.querySelector('.raw-material-select');
                const quantityInput = row.querySelector('.quantity-input');
                const costOutput = row.querySelector('.cost-output');

                const unitPrice = parseFloat(select.selectedOptions[0]?.dataset.price || 0);
                const quantity = parseInt(quantityInput.value || 0);
                const cost = unitPrice * quantity;

                costOutput.value = isNaN(cost) ? '' : cost.toFixed(2);
                if (!isNaN(cost)) {
                    total += cost;
                }
            });
            totalCostDisplay.textContent = total.toFixed(2);
        }

        function disableDuplicateOptions() {
            const selects = wrapper.querySelectorAll('.raw-material-select');
            const selectedValues = Array.from(selects).map(s => s.value);

            selects.forEach(select => {
                Array.from(select.options).forEach(option => {
                    if (option.value && selectedValues.includes(option.value) && select
                        .value !== option.value) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                });
            });
        }

        addButton.addEventListener('click', function() {
            const row = document.createElement('div');
            row.className = 'input-group mb-2 raw-material-row';
            row.innerHTML = `
                <select name="raw_materials[]" class="form-select me-2 raw-material-select" required>
                    <option value="">Select raw material</option>
                    @foreach ($rawMaterials as $rm)
                        <option value="{{ $rm->id }}" data-price="{{ $rm->unit_price }}">{{ $rm->name }}</option>
                    @endforeach
                </select>
                <input type="number" name="quantities[]" class="form-control me-2 quantity-input" placeholder="Quantity" value="1" required>
                <input type="text" class="form-control me-2 cost-output" placeholder="Cost" readonly>
                <button type="button" class="btn btn-danger remove-material">Remove</button>
            `;
            wrapper.appendChild(row);
            updateCosts();
            disableDuplicateOptions();
        });

        wrapper.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-material')) {
                e.target.closest('.raw-material-row').remove();
                updateCosts();
                disableDuplicateOptions();
            }
        });

        wrapper.addEventListener('input', function(e) {
            if (e.target.matches('.quantity-input') || e.target.matches('.raw-material-select')) {
                updateCosts();
                disableDuplicateOptions();
            }
        });

        wrapper.addEventListener('change', function(e) {
            if (e.target.matches('.raw-material-select')) {
                updateCosts();
                disableDuplicateOptions();
            }
        });

        form.addEventListener("submit", function(e) {
            const selectedValues = [];
            let hasDuplicate = false;

            wrapper.querySelectorAll('.raw-material-select').forEach(select => {
                const value = select.value;
                if (value && selectedValues.includes(value)) {
                    hasDuplicate = true;
                } else if (value) {
                    selectedValues.push(value);
                }
            });

            if (hasDuplicate) {
                e.preventDefault();
                alert("Duplicate raw materials selected. Please choose unique raw materials.");
            }
        });

        updateCosts();
        disableDuplicateOptions();
    });
</script>
