<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $supplier->name ?? '') }}"
                        class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $supplier->email ?? '') }}"
                        class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="city" class="form-label fw-bold">City</label>
                    <input type="text" name="city" value="{{ old('city', $supplier->city ?? '') }}"
                        class="form-control @error('city') is-invalid @enderror">
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="zip_code" class="form-label fw-bold">Zip Code</label>
                    <input type="text" name="zip_code" value="{{ old('zip_code', $supplier->zip_code ?? '') }}"
                        class="form-control @error('zip_code') is-invalid @enderror">
                    @error('zip_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="contact_person" class="form-label fw-bold">Contact Person <span class="text-danger">*</span></label>
                    <input type="text" name="contact_person" value="{{ old('contact_person', $supplier->contact_person ?? '') }}"
                        class="form-control @error('contact_person') is-invalid @enderror" required>
                    @error('contact_person')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="phone" class="form-label fw-bold">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $supplier->phone ?? '') }}"
                        class="form-control @error('phone') is-invalid @enderror" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="state" class="form-label fw-bold">State</label>
                    <input type="text" name="state" value="{{ old('state', $supplier->state ?? '') }}"
                        class="form-control @error('state') is-invalid @enderror">
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="country" class="form-label fw-bold">Country</label>
                    <input type="text" name="country" value="{{ old('country', $supplier->country ?? '') }}"
                        class="form-control @error('country') is-invalid @enderror">
                    @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-3">
                    <label for="address" class="form-label fw-bold">Address <span class="text-danger">*</span></label>
                    <input type="text" name="address" value="{{ old('address', $supplier->address ?? '') }}"
                        class="form-control @error('address') is-invalid @enderror" required>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="is_active" class="form-label fw-bold">Status</label>
                    <select name="is_active" class="form-select @error('is_active') is-invalid @enderror">
                        <option value="1" {{ old('is_active', $supplier->is_active ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', $supplier->is_active ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
