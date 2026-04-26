<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Driver Details
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow rounded">

                <div class="mb-4">
                    <strong>Name:</strong> {{ $driver->name }}
                </div>

                <div class="mb-4">
                    <strong>Phone:</strong> {{ $driver->phone }}
                </div>

                <div class="mb-4">
                    <strong>Email:</strong> {{ $driver->email }}
                </div>

                <div class="mb-4">
                    <strong>Vehicle Type:</strong> {{ $driver->vehicle_type }}
                </div>

                <div class="mb-4">
                    <strong>Available:</strong>
                    {{ $driver->is_available ? 'Yes' : 'No' }}
                </div>

                <div class="mb-4">
                    <strong>Notes:</strong> {{ $driver->notes }}
                </div>

                <div class="mt-6 flex gap-2">
                    <a href="{{ route('drivers.edit', $driver) }}"
                       class="bg-yellow-500 text-white px-4 py-2 rounded">
                        Edit
                    </a>

                    <a href="{{ route('drivers.index') }}"
                       class="bg-gray-300 px-4 py-2 rounded">
                        Back
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
