<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Inscritos en: {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Lista de Asistencia ({{ $event->participants->count() }} personas)</h3>
                    <a href="{{ route('admin.index') }}" class="text-gray-500 underline">Volver</a>
                </div>

                @if($event->participants->isEmpty())
                    <p class="text-gray-500 text-center py-10">Aún no hay nadie inscrito 😢</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Registro</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($event->participants as $user)
                            <tr>
                                <td class="px-6 py-4">{{ $user->name }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->pivot->created_at->format('d M H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="mt-8 text-center">
                        <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded">🖨️ Imprimir Lista</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>