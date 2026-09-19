<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $person->name }}
            </h2>
            <a href="{{ route('admin.people.index') }}" class="text-gray-500 underline text-sm">Volver</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="flex flex-wrap gap-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">Correo</p>
                        <p class="font-medium">{{ $person->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">Eventos a los que se registró</p>
                        <p class="font-medium">{{ $person->events->count() }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">Asistencias confirmadas</p>
                        <p class="font-medium">{{ $person->events->where('pivot.attended', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Historial de eventos</h3>

                @if($person->events->isEmpty())
                    <p class="text-gray-500 italic text-center py-10">Esta persona aún no se ha registrado a ningún evento.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Evento</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Asistió</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($person->events as $event)
                                <tr>
                                    <td class="px-4 py-4 font-bold">{{ $event->title }}</td>
                                    <td class="px-4 py-4 text-sm">{{ $event->start_date->translatedFormat('d M, Y') }}</td>
                                    <td class="px-4 py-4 font-mono text-sm text-[#DD2494] font-bold">{{ $event->pivot->confirmation_code ?? '—' }}</td>
                                    <td class="px-4 py-4 text-center">
                                        @if($event->pivot->attended)
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">✅ Sí</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-500">No</span>
                                        @endif
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
</x-app-layout>
