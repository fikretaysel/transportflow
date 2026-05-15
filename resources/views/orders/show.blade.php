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

            @if($order->isDelayed())
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-6">
                    <p class="text-red-600 font-bold mt-2">
                        Risk: This order is delayed.
                    </p>
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

                </p>
                <p><strong>Driver:</strong> {{ $order->driver?->name ?? 'Not assigned' }}</p>
                <p><strong>Scheduled At:</strong> {{ $order->scheduled_at }}</p>
                <p><strong>Completed At:</strong> {{ $order->completed_at }}</p>
            </div>

                <!-- STATUS UPDATE -->
                <div class="bg-white shadow rounded p-6 mb-6">
                    <h3 class="font-semibold text-lg mb-4">Update Status</h3>

                    @if(count($nextStatuses) > 0)
                        <form action="{{ route('orders.status', $order) }}" method="POST">
                            @csrf

                            <div class="flex gap-2 items-center">
                                <select name="status"
                                        class="border rounded px-3 py-2"
                                        style="min-width: 220px;"
                                        required>
                                    @foreach($nextStatuses as $status)
                                        <option value="{{ $status }}">
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </option>
                                    @endforeach
                                </select>

                                <input type="text"
                                       name="note"
                                       placeholder="Note"
                                       class="border rounded px-3 py-2 flex-1">

                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                                    Update
                                </button>
                            </div>
                        </form>
                    @else
                        <p class="text-sm text-gray-500">
                            This order has already reached its final status.
                        </p>
                    @endif
                </div>

                <!-- TIMELINE -->
                <div class="bg-white shadow rounded p-6 mb-6">
                    <h3 class="font-semibold text-lg mb-4">Timeline</h3>

                    <div class="space-y-4">
                        @forelse($order->events as $event)
                            <div class="border-l-4 border-blue-500 pl-4 py-2 bg-gray-50 rounded">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-sm text-blue-700">
                                        {{ ucfirst(str_replace('_', ' ', $event->event_type)) }}
                                    </span>

                                    <span class="text-xs text-gray-500">
                                        {{ $event->created_at->format('Y-m-d H:i') }}
                                    </span>
                                </div>

                                @if($event->note)
                                    <p class="text-sm text-gray-700 mt-1">
                                        {{ $event->note }}
                                    </p>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">
                                No events recorded yet.
                            </p>
                        @endforelse
                    </div>
                </div>

            <a href="{{ route('orders.index') }}" class="bg-gray-300 px-4 py-2 rounded">
                Back to Orders
            </a>

        </div>
    </div>
</x-app-layout>
