<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Administrar Programas
            </h2>
            <a href="{{ route('admin.programs.create') }}" class="bg-gradient-to-r from-[#DD2494] to-[#E65E0B] text-white px-4 py-2 rounded-lg font-bold hover:opacity-90 text-sm">
                + Nuevo Programa
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-sm text-gray-500 mb-4">
                        Estos son los programas que aparecen en la sección "Move Your Company" del sitio.
                        Cada uno tiene su propia página pública con "Qué incluye" y precio.
                    </p>

                    @if($programs->isEmpty())
                        <p class="text-gray-500 italic">No hay programas creados todavía.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Programa</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orden</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ver en sitio</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($programs as $programa)
                                    <tr>
                                        <td class="px-4 py-4 font-bold">
                                            <div class="flex items-center gap-3">
                                                @if($programa->image_url)
                                                    <img src="{{ $programa->image_url }}"
                                                         style="width:48px;height:48px;object-fit:cover;border-radius:8px;flex:0 0 auto;"
                                                         alt="{{ $programa->title }}">
                                                @endif
                                                <span>{{ $programa->title }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm">{{ $programa->price ?? '—' }}</td>
                                        <td class="px-4 py-4 text-sm">{{ $programa->order }}</td>
                                        <td class="px-4 py-4 text-sm">
                                            <a href="{{ route('programs.show', $programa->slug) }}" target="_blank" class="text-gray-500 hover:underline">
                                                /programas/{{ $programa->slug }} ↗
                                            </a>
                                        </td>
                                        <td class="px-4 py-4 text-right text-sm font-medium space-x-2">
                                            <a href="{{ route('admin.programs.edit', $programa->id) }}" class="text-[#E65E0B] font-bold">Editar</a>
                                            <form action="{{ route('admin.programs.destroy', $programa->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Borrar este programa?');">
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
