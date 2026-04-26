<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Drivers
            </h2>

            <a href="{{ route('drivers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                New Driver
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
                        <th class="text-left px-4 py-3">Name</th>
                        <th class="text-left px-4 py-3">Phone</th>
                        <th class="text-left px-4 py-3">Email</th>
                        <th class="text-left px-4 py-3">Vehicle Type</th>
                        <th class="text-left px-4 py-3">Available</th>
                        <th class="text-left px-4 py-3">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($drivers as $driver)
                        <tr class="border-t">
                            <td class="px-4 py-3">{{ $driver->name }}</td>
                            <td class="px-4 py-3">{{ $driver->phone }}</td>
                            <td class="px-4 py-3">{{ $driver->email }}</td>
                            <td class="px-4 py-3">{{ $driver->vehicle_type }}</td>
                            <td class="px-4 py-3">
                                {{ $driver->is_available ? 'Yes' : 'No' }}
                            </td>
                            <td class="px-4 py-3 flex gap-2">
                                <a href="{{ route('drivers.show', $driver) }}" class="text-blue-600">
                                    View
                                </a>

                                <a href="{{ route('drivers.edit', $driver) }}" class="text-yellow-600">
                                    Edit
                                </a>

                                <form action="{{ route('drivers.destroy', $driver) }}" method="POST"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-600">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                No drivers found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $drivers->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
