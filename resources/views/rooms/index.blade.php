<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter Section -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mb-8">
                <form action="{{ route('rooms.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        
                        <div class="md:col-span-6">
                            <label for="search" class="block text-sm font-semibold text-gray-700 mb-1.5">Find a Room</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="text" 
                                    name="search" 
                                    id="search" 
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-200" 
                                    placeholder="Search by name or facilities..." 
                                    value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="md:col-span-3">
                            <label for="capacity" class="block text-sm font-semibold text-gray-700 mb-1.5">Min. Capacity</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <input type="number" 
                                    name="capacity" 
                                    id="capacity" 
                                    min="1"
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-200" 
                                    placeholder="People" 
                                    value="{{ request('capacity') }}">
                            </div>
                        </div>

                        <div class="md:col-span-3 flex gap-2">
                            <button type="submit" class="flex-1 inline-flex justify-center items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Search
                            </button>
                            
                            @if(request()->has('search') || request()->has('capacity'))
                                <a href="{{ route('rooms.index') }}" class="inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                    Reset
                                </a>
                            @endif
                        </div>

                    </div>
                </form>
            </div>

            <!-- Rooms Grid -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">Available Rooms</h3>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            <span>Grid view</span>
                        </div>
                    </div>

                    @if($rooms->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($rooms as $room)
                                <div class="group bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg hover:border-indigo-200 transition-all duration-300 overflow-hidden">
                                    <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                                    <div class="p-5">
                                        <div class="flex justify-between items-start mb-3">
                                            <h4 class="text-xl font-bold text-gray-900 group-hover:text-indigo-700 transition-colors">{{ $room->name }}</h4>
                                        </div>
                                        
                                        <div class="flex items-center text-gray-600 mb-3">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Capacity: {{ $room->capacity }} people</span>
                                        </div>

                                        <div class="mb-4">
                                            <div class="flex items-center text-gray-600 mb-2">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                </svg>
                                                <span class="text-sm font-medium">Facilities</span>
                                            </div>
                                            <p class="text-gray-700 text-sm pl-5">{{ $room->facilities }}</p>
                                        </div>

                                        @if ($room->description)
                                            <div class="mb-4">
                                                <p class="text-gray-600 text-sm leading-relaxed">{{ Str::limit($room->description, 120) }}</p>
                                            </div>
                                        @endif

                                        <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100">
                                            <div class="text-indigo-600 font-semibold group-hover:text-indigo-700 transition-colors">
                                                View Details & Book
                                            </div>
                                            <a href="{{ route('rooms.show', $room) }}" 
                                               class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 group-hover:bg-indigo-100 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto w-24 h-24 mb-4 text-gray-300">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No rooms available</h3>
                            <p class="text-gray-500 max-w-md mx-auto">There are no rooms available at the moment. Please check back later or contact administration.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>