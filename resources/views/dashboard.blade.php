<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Panel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 shadow-sm" role="alert">
                    <strong class="font-bold">¡Genial!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 shadow-sm" role="alert">
                    <strong class="font-bold">Error:</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-6 text-gray-800 border-b pb-2">🎫 Mis Próximos Eventos</h3>
                    
                    @if($myEvents->isEmpty())
                        <div class="text-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <p class="text-gray-500 mb-4">No tienes eventos próximos.</p>
                            <a href="{{ url('/') }}" class="text-pink-600 font-bold hover:underline">
                                Ver cartelera de eventos
                            </a>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($myEvents as $event)
                                <a href="{{ route('event.detail', $event->id) }}" class="block group">
                                    <div class="flex items-center bg-white border border-gray-200 rounded-lg p-3 hover:shadow-md hover:border-pink-300 transition duration-200">
                                        
                                        <div class="flex-shrink-0 mr-4">
                                            <img src="{{ $event->image_url ?? 'https://via.placeholder.com/60' }}" class="w-14 h-14 rounded-full object-cover border border-gray-100 group-hover:scale-105 transition">
                                        </div>
                                        
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-lg font-bold text-gray-800 truncate group-hover:text-pink-600 transition">
                                                {{ $event->title }}
                                            </h4>
                                            <p class="text-sm text-gray-500 flex items-center">
                                                📅 {{ $event->start_date->format('d M Y') }} &nbsp;•&nbsp; 
                                                ⏰ {{ $event->start_date->format('h:i A') }}
                                            </p>
                                        </div>

                                        <div class="ml-4 flex-shrink-0 text-gray-400 group-hover:text-pink-500 transition">
                                            <span class="text-sm font-medium mr-2 hidden sm:inline">Ver detalles</span>
                                            <span class="text-xl">→</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>