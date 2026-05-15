<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Orders
            </h2>

            <a href="{{ route('orders.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                New Order
            </a>
        </div>
        @if(request('filter'))
            <div class="mb-4 text-sm text-gray-600">
                Current filter: <strong style="color:red">{{ ucfirst(request('filter')) }}</strong>
            </div>
        @endif
    </x-slot>



    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-4 py-3">Customer</th>
                        <th class="text-left px-4 py-3">Route</th>
                        <th class="text-left px-4 py-3">Driver</th>
                        <th class="text-left px-4 py-3">Priority</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($orders as $order)
                        <tr class="border-t">
                            <td class="px-4 py-3">
                                <div class="font-medium">{{ $order->customer_name }}</div>
                                <div class="text-sm text-gray-500">{{ $order->customer_phone }}</div>
                            </td>

                            <td class="px-4 py-3">
                                <div class="text-sm">From: {{ $order->pickup_address }}</div>
                                <div class="text-sm">To: {{ $order->dropoff_address }}</div>
                            </td>

                            <td class="px-4 py-3">
                                {{ $order->driver?->name ?? 'Not assigned' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ ucfirst($order->priority) }}
                            </td>

                            <td class="px-4 py-3">
                                {{ str_replace('_', ' ', ucfirst($order->status)) }}

                                @if($order->isDelayed())
                                    <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded">
                                        Delayed
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 flex gap-2">
                                <a href="{{ route('orders.show', $order) }}" class="text-blue-600">View</a>
                                <a href="{{ route('orders.edit', $order) }}" class="text-yellow-600">Edit</a>

                                <form action="{{ route('orders.destroy', $order) }}" method="POST"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
