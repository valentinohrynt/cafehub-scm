<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" value="{{ old('name', $supplier->name ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label for="contact_person" class="form-label">Contact Person</label>
        <input type="text" name="contact_person" value="{{ old('contact_person', $supplier->contact_person ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $supplier->email ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $supplier->phone ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-12">
        <label for="address" class="form-label">Address</label>
        <input type="text" name="address" value="{{ old('address', $supplier->address ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label for="city" class="form-label">City</label>
        <input type="text" name="city" value="{{ old('city', $supplier->city ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label for="state" class="form-label">State</label>
        <input type="text" name="state" value="{{ old('state', $supplier->state ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label for="zip_code" class="form-label">Zip Code</label>
        <input type="text" name="zip_code" value="{{ old('zip_code', $supplier->zip_code ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label for="country" class="form-label">Country</label>
        <input type="text" name="country" value="{{ old('country', $supplier->country ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label for="is_active" class="form-label">Status</label>
        <select name="is_active" class="form-select">
            <option value="1" {{ old('is_active', $supplier->is_active ?? 1) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('is_active', $supplier->is_active ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
</div>
