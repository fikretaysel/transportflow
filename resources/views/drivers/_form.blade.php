<div class="mb-4">
    <label class="block font-medium">Name</label>
    <input type="text" name="name"
           value="{{ old('name', $driver->name ?? '') }}"
           class="w-full border rounded px-3 py-2">

    @error('name')
    <div class="text-red-600 text-sm">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="block font-medium">Phone</label>
    <input type="text" name="phone"
           value="{{ old('phone', $driver->phone ?? '') }}"
           class="w-full border rounded px-3 py-2">
</div>

<div class="mb-4">
    <label class="block font-medium">Email</label>
    <input type="email" name="email"
           value="{{ old('email', $driver->email ?? '') }}"
           class="w-full border rounded px-3 py-2">
</div>

<div class="mb-4">
    <label class="block font-medium">Vehicle Type</label>
    <input type="text" name="vehicle_type"
           value="{{ old('vehicle_type', $driver->vehicle_type ?? '') }}"
           class="w-full border rounded px-3 py-2">
</div>

<div class="mb-4">
    <label class="inline-flex items-center">
        <input type="checkbox" name="is_available" value="1"
            {{ old('is_available', $driver->is_available ?? true) ? 'checked' : '' }}>
        <span class="ml-2">Available</span>
    </label>
</div>

<div class="mb-4">
    <label class="block font-medium">Notes</label>
    <textarea name="notes" class="w-full border rounded px-3 py-2">
        {{ old('notes', $driver->notes ?? '') }}
    </textarea>
</div>

<button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
    Save
</button>
