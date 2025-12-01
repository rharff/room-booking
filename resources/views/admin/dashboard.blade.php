<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welcome, Admin!</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <a href="{{ route('admin.rooms.index') }}" class="block bg-gray-50 p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                            <h4 class="text-xl font-bold text-gray-900">Manage Rooms</h4>
                            <p class="text-gray-600 mt-2">Add, edit, or delete rooms.</p>
                        </a>
                        <a href="{{ route('admin.bookings.index') }}" class="block bg-gray-50 p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                            <h4 class="text-xl font-bold text-gray-900">Manage Bookings</h4>
                            <p class="text-gray-600 mt-2">Approve or reject booking requests.</p>
                        </a>
                    </div>

                    <h3 class="text-lg font-semibold mb-4">Booked Rooms Calendar (Current Month)</h3>

                    <div class="bg-gray-50 p-4 rounded-lg shadow">
                        <div class="flex justify-between items-center mb-4">
                            <a href="{{ route('admin.dashboard', ['year' => $previousMonthDate->year, 'month' => $previousMonthDate->month]) }}" class="px-3 py-1 bg-gray-200 rounded-md hover:bg-gray-300">
                                &larr; Previous Month
                            </a>
                            <h4 class="text-center text-xl font-bold">{{ $date->format('F Y') }}</h4>
                            <a href="{{ route('admin.dashboard', ['year' => $nextMonthDate->year, 'month' => $nextMonthDate->month]) }}" class="px-3 py-1 bg-gray-200 rounded-md hover:bg-gray-300">
                                Next Month &rarr;
                            </a>
                        </div>

                        <div class="grid grid-cols-7 gap-1 text-center font-semibold mb-2">
                            <div>Mon</div>
                            <div>Tue</div>
                            <div>Wed</div>
                            <div>Thu</div>
                            <div>Fri</div>
                            <div>Sat</div>
                            <div>Sun</div>
                        </div>

                        <div class="grid grid-cols-7 gap-1">
                            @foreach ($calendar as $day)
                                <div class="relative p-2 h-20 border rounded flex flex-col items-center justify-start
                                            @if ($day === null) bg-gray-100
                                            @else bg-white @endif">
                                    @if ($day !== null)
                                        <span class="text-sm font-medium">{{ $day }}</span>
                                        @if (isset($bookedDays[$day]))
                                            <div class="flex-grow mt-1 w-full overflow-y-auto text-xs">
                                                @foreach ($bookedDays[$day] as $booking)
                                                    <div class="bg-indigo-200 text-indigo-800 rounded px-1 py-0.5 mb-0.5"
                                                         title="{{ $booking->room->name }} ({{ $booking->user->name }}) {{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}">
                                                        {{ $booking->room->name }} {{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }} 
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
