<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>

            <div class="flex gap-2">
                <a href="{{ route('orders.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                    New Order
                </a>

                <a href="{{ route('drivers.create') }}" class="bg-gray-700 text-white px-4 py-2 rounded">
                    New Driver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid gap-4 mb-6" style="grid-template-columns: repeat(5, 1fr);">

                <div class="bg-white shadow rounded p-5 text-center flex flex-col items-center">
                    <div class="text-sm text-gray-500">Total Orders</div>
                    <div class="text-3xl font-bold">{{ $totalOrders }}</div>
                    <a href="{{ route('orders.index') }}" class="text-blue-600 text-sm mt-2 inline-block">
                        View
                    </a>
                </div>

                <div class="bg-white shadow rounded p-5 text-center flex flex-col items-center">
                    <div class="text-sm text-gray-500">Active Orders</div>
                    <div class="text-3xl font-bold">{{ $activeOrders }}</div>
                    <a href="{{ route('orders.index', ['filter' => 'active']) }}" class="text-blue-600 text-sm mt-2 inline-block">
                        View
                    </a>
                </div>

                <div class="bg-white shadow rounded p-5 text-center flex flex-col items-center">
                    <div class="text-sm text-gray-500">Completed Orders</div>
                    <div class="text-3xl font-bold">{{ $completedOrders }}</div>
                    <a href="{{ route('orders.index', ['filter' => 'completed']) }}" class="text-blue-600 text-sm mt-2 inline-block">
                        View
                    </a>
                </div>

                <div class="bg-white shadow rounded p-5 text-center flex flex-col items-center">
                    <div class="text-sm text-gray-500">Delayed Orders</div>
                    <div class="text-3xl font-bold text-red-600">{{ $delayedOrders }}</div>
                    <a href="{{ route('orders.index', ['filter' => 'delayed']) }}" class="text-blue-600 text-sm mt-2 inline-block">
                        View
                    </a>
                </div>

                <div class="bg-white shadow rounded p-5 text-center flex flex-col items-center">
                    <div class="text-sm text-gray-500">Available Drivers</div>
                    <div class="text-3xl font-bold">{{ $availableDrivers }}</div>
                    <a href="{{ route('drivers.index', ['filter' => 'available']) }}" class="text-blue-600 text-sm mt-2 inline-block">
                        View
                    </a>
                </div>

            </div>

            <div class="bg-white shadow rounded p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-lg">
                        Latest Orders
                    </h3>

                    <a href="{{ route('orders.index') }}" class="text-blue-600">
                        View all
                    </a>
                </div>

                <table class="w-full">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-4 py-3">Customer</th>
                        <th class="text-left px-4 py-3">Driver</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Created</th>
                        <th class="text-left px-4 py-3">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($latestOrders as $order)
                        <tr class="border-t">
                            <td class="px-4 py-3">
                                {{ $order->customer_name }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $order->driver?->name ?? 'Not assigned' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ str_replace('_', ' ', ucfirst($order->status)) }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $order->created_at->format('Y-m-d H:i') }}
                            </td>

                            <td class="px-4 py-3">
                                <a href="{{ route('orders.show', $order) }}" class="text-blue-600">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                No orders yet.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
