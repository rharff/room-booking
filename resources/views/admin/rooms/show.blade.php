<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Room Details: ') . $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $room->name }}</h3>
                        <p class="text-gray-700 mt-2">Capacity: {{ $room->capacity }} people</p>
                        <p class="text-gray-700">Facilities: {{ $room->facilities }}</p>
                        @if ($room->description)
                            <p class="text-gray-700 mt-2">{{ $room->description }}</p>
                        @endif
                    </div>
                    <div class="flex items-center justify-start mt-4">
                        <a href="{{ route('admin.rooms.edit', $room) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150 mr-2">
                            Edit Room
                        </a>
                        <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150" onclick="return confirm('Are you sure you want to delete this room?')">
                                Delete Room
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
