<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Panel de Administración
            </h2>
            <a href="{{ route('admin.create') }}" class="bg-pink-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-pink-700 text-sm">
                + Nuevo Evento
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Listado de Eventos</h3>
                    
                    @if($events->isEmpty())
                        <p class="text-gray-500 italic">No hay eventos creados.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Evento</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Ocupación</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($events as $event)
                                    <tr>
                                        <td class="px-4 py-4 font-bold">{{ $event->title }}</td>
                                        <td class="px-4 py-4 text-sm">{{ $event->start_date->format('d/m/Y') }}</td>
                                        <td class="px-4 py-4 text-center">
                                            <span class="px-2 py-1 text-xs font-bold rounded-full {{ $event->participants->count() >= $event->capacity ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $event->participants->count() }} / {{ $event->capacity }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-right text-sm font-medium space-x-2">
                                            <a href="{{ route('admin.show', $event->id) }}" class="text-blue-600 font-bold">Ver Lista</a>
                                            <a href="{{ route('admin.edit', $event->id) }}" class="text-indigo-600">Editar</a>
                                            <form action="{{ route('admin.destroy', $event->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Borrar evento?');">
                                                @csrf @method('DELETE')
                                                <button class="text-red-600">Borrar</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>