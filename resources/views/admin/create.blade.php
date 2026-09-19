<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo Evento
        </h2>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">
            
            <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Título del Evento</label>
                    <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Descripción</label>
                    <textarea name="description" class="w-full border rounded px-3 py-2 h-24" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Recomendaciones (Opcional)</label>
                    <textarea name="recommendations" class="w-full border rounded px-3 py-2 h-20" placeholder="Ej: Llevar agua, toalla y llegar 10 min antes..."></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Fecha y Hora</label>
                    <input type="datetime-local" name="start_date" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Lugar / Ubicación</label>
                    <input type="text" name="location" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Cupo Máximo (Personas)</label>
                    <input type="number" name="capacity" class="w-full border rounded px-3 py-2" value="50">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Precio del evento (MXN)</label>
                    <input type="number" step="0.01" name="price" class="w-full border rounded px-3 py-2" value="{{ old('price') }}">
                    <p class="text-xs text-gray-400 mt-1">Déjalo vacío o en 0 si es gratuito.</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Imagen del Evento</label>
                    <input type="file" name="image_file" accept="image/*"
                           class="w-full border rounded px-3 py-2 file:mr-3 file:py-2 file:px-4 file:rounded file:border-0 file:bg-[#DD2494] file:text-white file:font-bold file:cursor-pointer">
                    <p class="text-xs text-gray-400 mt-1">Sube una foto desde tu computadora (JPG o PNG, máx. 4MB).</p>

                    <div class="mt-3">
                        <label class="block text-gray-500 text-sm mb-1">…o pega una URL (opcional)</label>
                        <input type="url" name="image_url" placeholder="https://..." class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Ajuste de la imagen</label>
                    <select name="image_position" class="w-full border rounded px-3 py-2">
                        <option value="top" {{ old('image_position') === 'top' ? 'selected' : '' }}>Mostrar la parte de arriba (ideal para caras)</option>
                        <option value="center" {{ old('image_position', 'center') === 'center' ? 'selected' : '' }}>Centrada</option>
                        <option value="bottom" {{ old('image_position') === 'bottom' ? 'selected' : '' }}>Mostrar la parte de abajo</option>
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
                        Guardar Evento
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>