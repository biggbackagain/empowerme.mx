<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Personas registradas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-sm text-gray-500 mb-4">
                    Todas las personas que se han registrado en la plataforma y a cuántos eventos han asistido.
                </p>

                {{-- Buscador --}}
                <form method="GET" action="{{ route('admin.people.index') }}" class="mb-6 flex gap-2">
                    <input type="text" name="q" value="{{ $buscar }}" placeholder="Buscar por nombre o correo..."
                           class="flex-1 border rounded-lg px-4 py-2 focus:border-[#DD2494] focus:ring-[#DD2494]">
                    <button type="submit" style="background: linear-gradient(90deg,#DD2494 0%,#E65E0B 100%); color:white;"
                            class="px-5 py-2 rounded-lg font-bold shadow hover:opacity-90 transition">Buscar</button>
                    @if($buscar !== '')
                        <a href="{{ route('admin.people.index') }}" class="px-4 py-2 text-gray-500 underline">Limpiar</a>
                    @endif
                </form>

                @if($people->isEmpty())
                    <p class="text-gray-500 italic text-center py-10">No se encontraron personas.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Eventos</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Detalle</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($people as $person)
                                <tr>
                                    <td class="px-4 py-4 font-bold">{{ $person->name }}</td>
                                    <td class="px-4 py-4 text-sm text-gray-500">{{ $person->email }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="px-3 py-1 text-sm font-bold rounded-full {{ $person->events_count > 0 ? 'bg-pink-100 text-[#DD2494]' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $person->events_count }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <a href="{{ route('admin.people.show', $person->id) }}" class="text-[#E65E0B] font-bold text-sm">Ver eventos →</a>
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
