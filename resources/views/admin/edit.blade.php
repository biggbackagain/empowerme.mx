<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Evento: {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">
            
            <form action="{{ route('admin.update', $event->id) }}" method="POST" enctype="multipart/form-data">
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
                    <label class="block text-gray-700 font-bold mb-2">Precio del evento (MXN)</label>
                    <input type="number" step="0.01" name="price" class="w-full border rounded px-3 py-2" value="{{ $event->price }}">
                    <p class="text-xs text-gray-400 mt-1">Déjalo vacío o en 0 si es gratuito.</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Imagen del Evento</label>

                    @if($event->image_url)
                        <img src="{{ $event->image_url }}" class="mb-3 w-full max-w-xs rounded-lg object-cover h-32">
                    @endif

                    <input type="file" name="image_file" accept="image/*"
                           class="w-full border rounded px-3 py-2 file:mr-3 file:py-2 file:px-4 file:rounded file:border-0 file:bg-[#DD2494] file:text-white file:font-bold file:cursor-pointer">
                    <p class="text-xs text-gray-400 mt-1">Sube una foto nueva desde tu computadora para reemplazar la actual (máx. 4MB).</p>

                    <div class="mt-3">
                        <label class="block text-gray-500 text-sm mb-1">…o pega una URL</label>
                        <input type="url" name="image_url" class="w-full border rounded px-3 py-2 text-sm" value="{{ $event->image_url }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Ajuste de la imagen</label>
                    @php $pos = old('image_position', $event->image_position ?? 'center'); @endphp
                    <select name="image_position" class="w-full border rounded px-3 py-2">
                        <option value="top" {{ $pos === 'top' ? 'selected' : '' }}>Mostrar la parte de arriba (ideal para caras)</option>
                        <option value="center" {{ $pos === 'center' ? 'selected' : '' }}>Centrada</option>
                        <option value="bottom" {{ $pos === 'bottom' ? 'selected' : '' }}>Mostrar la parte de abajo</option>
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Elige qué parte de la foto se ve cuando la imagen no cabe completa.</p>
                </div>

                <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100">
                    
                    <a href="{{ route('dashboard') }}" class="text-gray-500 font-medium hover:underline">
                        Cancelar
                    </a>

                    <button type="submit" 
                            style="background: linear-gradient(90deg, #DD2494 0%, #E65E0B 100%); color: white;" 
                            class="px-6 py-3 rounded-lg font-bold shadow-lg hover:opacity-90 transition">
                        Actualizar Cambios
                    </button>
                    
                </div>
            </form>
        </div>
    </div>
</x-app-layout>