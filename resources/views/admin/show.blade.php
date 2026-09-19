<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Inscritos en: {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl font-medium">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl font-medium">
                    {{ session('error') }}
                </div>
            @endif

            {{-- CHECK-IN POR CÓDIGO --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6 border-l-4 border-[#DD2494]">
                <h3 class="text-lg font-bold mb-1">Registrar asistencia por código</h3>
                <p class="text-sm text-gray-500 mb-4">Pega o escribe el código que muestra la persona (ej. EM-7K3F9) y confirma su asistencia al instante.</p>
                <form action="{{ route('admin.checkin', $event->id) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input type="text" name="confirmation_code" required autofocus
                           placeholder="EM-XXXXX"
                           class="flex-1 border rounded-lg px-4 py-3 text-lg font-bold tracking-widest uppercase focus:border-[#DD2494] focus:ring-[#DD2494]">
                    <button type="submit"
                            style="background: linear-gradient(90deg,#DD2494 0%,#E65E0B 100%); color:white;"
                            class="px-6 py-3 rounded-lg font-bold shadow hover:opacity-90 transition">
                        Confirmar asistencia
                    </button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @php
                    $asistieron = $event->participants->where('pivot.attended', true)->count();
                @endphp
                <div class="flex flex-wrap justify-between items-center mb-6 gap-2">
                    <h3 class="text-lg font-bold">
                        Lista de Asistencia
                        <span class="text-sm font-normal text-gray-500">
                            ({{ $event->participants->count() }} inscritos · {{ $asistieron }} ya asistieron)
                        </span>
                    </h3>
                    <a href="{{ route('admin.index') }}" class="text-gray-500 underline text-sm">Volver</a>
                </div>

                @if($event->participants->isEmpty())
                    <p class="text-gray-500 text-center py-10">Aún no hay nadie inscrito.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Asistió</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($event->participants as $user)
                                <tr class="{{ $user->pivot->attended ? 'bg-green-50' : '' }}">
                                    <td class="px-4 py-4 font-medium">{{ $user->name }}</td>
                                    <td class="px-4 py-4">
                                        <span class="font-mono font-bold text-[#DD2494] tracking-wider">{{ $user->pivot->confirmation_code ?? '—' }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <form action="{{ route('admin.attendance.toggle', [$event->id, $user->id]) }}" method="POST" class="inline">
                                            @csrf
                                            @if($user->pivot->attended)
                                                <button type="submit" class="inline-flex items-center gap-1 bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-bold hover:bg-green-200 transition">
                                                    ✅ Sí
                                                </button>
                                            @else
                                                <button type="submit" class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-sm font-medium hover:bg-gray-200 transition">
                                                    Marcar
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 text-center">
                        <button onclick="window.print()" class="bg-[#111111] text-white px-4 py-2 rounded hover:opacity-90 transition">🖨️ Imprimir Lista</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
