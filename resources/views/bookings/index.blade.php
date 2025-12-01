<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">My Room Bookings</h3>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @forelse ($bookings as $booking)
                        <div class="mb-4 p-4 border rounded-lg shadow-sm">
                            <h4 class="text-xl font-bold">{{ $booking->room->name }}</h4>
                            <p class="text-gray-600">Purpose: {{ $booking->purpose }}</p>
                            <p class="text-gray-600">From: {{ $booking->start_time->format('d M Y H:i') }}</p>
                            <p class="text-gray-600">To: {{ $booking->end_time->format('d M Y H:i') }}</p>
                            <p class="text-gray-700 font-semibold">Status:
                                @if ($booking->status === 'pending')
                                    <span class="text-yellow-600">{{ ucfirst($booking->status) }}</span>
                                @elseif ($booking->status === 'approved')
                                    <span class="text-green-600">{{ ucfirst($booking->status) }}</span>
                                @else
                                    <span class="text-red-600">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </p>
                        </div>
                    @empty
                        <p class="text-gray-600">You have no bookings yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
