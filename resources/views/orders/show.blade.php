<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Order #{{ $order->id }}
            </h2>

            <a href="{{ route('orders.edit', $order) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">
                Edit
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- CUSTOMER -->
            <div class="bg-white shadow rounded p-6 mb-6">
                <h3 class="font-semibold text-lg mb-4">Customer</h3>

                <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
            </div>

            <!-- TRANSPORT -->
            <div class="bg-white shadow rounded p-6 mb-6">
                <h3 class="font-semibold text-lg mb-4">Transport Details</h3>

                <p><strong>Pickup:</strong> {{ $order->pickup_address }}</p>
                <p><strong>Dropoff:</strong> {{ $order->dropoff_address }}</p>
                <p><strong>Vehicle:</strong> {{ $order->vehicle_model }} / {{ $order->vehicle_plate }}</p>
                <p><strong>Service Type:</strong> {{ ucfirst($order->service_type) }}</p>
                <p><strong>Priority:</strong> {{ ucfirst($order->priority) }}</p>
                <p><strong>Status:</strong> {{ str_replace('_', ' ', ucfirst($order->status)) }}
                    @if($order->scheduled_at && now()->gt($order->scheduled_at) && !in_array($order->status, ['completed', 'cancelled']))
                        <p class="text-red-600 font-bold mt-2">
                            Risk: This order is delayed.
                        </p>
                    @endif
                </p>
                <p><strong>Driver:</strong> {{ $order->driver?->name ?? 'Not assigned' }}</p>
                <p><strong>Scheduled At:</strong> {{ $order->scheduled_at }}</p>
                <p><strong>Completed At:</strong> {{ $order->completed_at }}</p>
            </div>

            <!-- STATUS UPDATE -->
            <div class="bg-white shadow rounded p-6 mb-6">
                <h3 class="font-semibold text-lg mb-4">Update Status</h3>

                <form action="{{ route('orders.status', $order) }}" method="POST">
                    @csrf

                    <div class="flex gap-2">
                        <select name="status" class="border rounded px-3 py-2">
                            @foreach(['new','assigned','on_the_way','picked_up','delivered','completed'] as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>

                        <input type="text" name="note" placeholder="Note"
                               class="border rounded px-3 py-2">

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Update
                        </button>
                    </div>
                </form>
            </div>

            <!-- TIMELINE -->
            <div class="bg-white shadow rounded p-6 mb-6">
                <h3 class="font-semibold text-lg mb-4">Timeline</h3>

                <ul>
                    @foreach($order->events as $event)
                        <li class="border-b py-2">
                            <strong>{{ $event->event_type }}</strong>
                            - {{ $event->created_at->format('Y-m-d H:i') }}

                            @if($event->note)
                                <div class="text-sm text-gray-500">
                                    {{ $event->note }}
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <a href="{{ route('orders.index') }}" class="bg-gray-300 px-4 py-2 rounded">
                Back to Orders
            </a>

        </div>
    </div>
</x-app-layout>
