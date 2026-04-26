<div class="mb-4">
    <label class="block font-medium">Customer Name</label>
    <input type="text" name="customer_name"
           value="{{ old('customer_name', $order->customer_name ?? '') }}"
           class="w-full border rounded px-3 py-2">
    @error('customer_name')
    <div class="text-red-600 text-sm">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="block font-medium">Customer Phone</label>
    <input type="text" name="customer_phone"
           value="{{ old('customer_phone', $order->customer_phone ?? '') }}"
           class="w-full border rounded px-3 py-2">
</div>

<div class="mb-4">
    <label class="block font-medium">Pickup Address</label>
    <input type="text" name="pickup_address"
           value="{{ old('pickup_address', $order->pickup_address ?? '') }}"
           class="w-full border rounded px-3 py-2">
    @error('pickup_address')
    <div class="text-red-600 text-sm">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="block font-medium">Dropoff Address</label>
    <input type="text" name="dropoff_address"
           value="{{ old('dropoff_address', $order->dropoff_address ?? '') }}"
           class="w-full border rounded px-3 py-2">
    @error('dropoff_address')
    <div class="text-red-600 text-sm">{{ $message }}</div>
    @enderror
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="mb-4">
        <label class="block font-medium">Vehicle Model</label>
        <input type="text" name="vehicle_model"
               value="{{ old('vehicle_model', $order->vehicle_model ?? '') }}"
               class="w-full border rounded px-3 py-2">
    </div>

    <div class="mb-4">
        <label class="block font-medium">Vehicle Plate</label>
        <input type="text" name="vehicle_plate"
               value="{{ old('vehicle_plate', $order->vehicle_plate ?? '') }}"
               class="w-full border rounded px-3 py-2">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="mb-4">
        <label class="block font-medium">Service Type</label>
        <select name="service_type" class="w-full border rounded px-3 py-2">
            @foreach(['transport', 'towing', 'recovery'] as $type)
                <option value="{{ $type }}" {{ old('service_type', $order->service_type ?? 'transport') == $type ? 'selected' : '' }}>
                    {{ ucfirst($type) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block font-medium">Priority</label>
        <select name="priority" class="w-full border rounded px-3 py-2">
            @foreach(['low', 'normal', 'high', 'urgent'] as $priority)
                <option value="{{ $priority }}" {{ old('priority', $order->priority ?? 'normal') == $priority ? 'selected' : '' }}>
                    {{ ucfirst($priority) }}
                </option>
            @endforeach
        </select>
    </div>
</div>

@if(isset($showStatus) && $showStatus)
    <div class="mb-4">
        <label class="block font-medium">Status</label>
        <select name="status" class="w-full border rounded px-3 py-2">
            @foreach(['new', 'assigned', 'on_the_way', 'picked_up', 'delivered', 'completed', 'cancelled'] as $status)
                <option value="{{ $status }}" {{ old('status', $order->status ?? 'new') == $status ? 'selected' : '' }}>
                    {{ str_replace('_', ' ', ucfirst($status)) }}
                </option>
            @endforeach
        </select>
    </div>
@endif

<div class="mb-4">
    <label class="block font-medium">Assign Driver</label>
    <select name="assigned_driver_id" class="w-full border rounded px-3 py-2">
        <option value="">No driver assigned</option>
        @foreach($drivers as $driver)
            <option value="{{ $driver->id }}" {{ old('assigned_driver_id', $order->assigned_driver_id ?? '') == $driver->id ? 'selected' : '' }}>
                {{ $driver->name }} - {{ $driver->vehicle_type }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label class="block font-medium">Scheduled At</label>
    <input type="datetime-local" name="scheduled_at"
           value="{{ old('scheduled_at', $order->scheduled_at ? \Carbon\Carbon::parse($order->scheduled_at)->format('Y-m-d\TH:i') : '') }}"
           class="w-full border rounded px-3 py-2">
</div>

<div class="flex gap-2">
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        Save
    </button>

    <a href="{{ route('orders.index') }}" class="bg-gray-300 px-4 py-2 rounded">
        Cancel
    </a>
</div>
