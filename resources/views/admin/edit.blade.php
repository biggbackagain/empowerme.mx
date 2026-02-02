<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Evento: {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">
            
            <form action="{{ route('admin.update', $event->id) }}" method="POST">
                @csrf
                @method('PUT') <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Título del Evento</label>
                    <input type="text" name="title" class="w-full border rounded px-3 py-2" value="{{ $event->title }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Descripción</label>
                    <textarea name="description" class="w-full border rounded px-3 py-2 h-24" required>{{ $event->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Recomendaciones</label>
                    <textarea name="recommendations" class="w-full border rounded px-3 py-2 h-20">{{ $event->recommendations }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Fecha y Hora</label>
                    <input type="datetime-local" name="start_date" class="w-full border rounded px-3 py-2" value="{{ $event->start_date->format('Y-m-d\TH:i') }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Lugar / Ubicación</label>
                    <input type="text" name="location" class="w-full border rounded px-3 py-2" value="{{ $event->location }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Cupo Máximo</label>
                    <input type="number" name="capacity" class="w-full border rounded px-3 py-2" value="{{ $event->capacity }}">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">URL de la Imagen</label>
                    <input type="url" name="image_url" class="w-full border rounded px-3 py-2" value="{{ $event->image_url }}">
                </div>

                <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100">
                    
                    <a href="{{ route('dashboard') }}" class="text-gray-500 font-medium hover:underline">
                        Cancelar
                    </a>

                    <button type="submit" 
                            style="background-color: #db2777; color: white;" 
                            class="px-6 py-3 rounded-lg font-bold shadow-lg hover:opacity-90 transition">
                        Actualizar Cambios
                    </button>
                    
                </div>
            </form>
        </div>
    </div>
</x-app-layout>