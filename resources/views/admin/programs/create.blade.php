<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo Programa
        </h2>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">

            <form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nombre del Programa</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded px-3 py-2" placeholder="Ej: Wellness Day" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Resumen corto</label>
                    <textarea name="summary" class="w-full border rounded px-3 py-2 h-24" placeholder="El texto que aparece en la tarjeta de inicio..." required>{{ old('summary') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Qué incluye (opcional)</label>
                    <textarea name="includes" class="w-full border rounded px-3 py-2 h-32" placeholder="Un punto por línea, por ejemplo:&#10;Sesión de activación física&#10;Kit de bienvenida&#10;Memoria fotográfica">{{ old('includes') }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Cada línea se mostrará como un punto de lista en la página del programa.</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Precio (opcional)</label>
                    <input type="text" name="price" value="{{ old('price') }}" class="w-full border rounded px-3 py-2" placeholder="Ej: $8,500 MXN o Cotiza con nosotros">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Precio numérico (MXN)</label>
                    <input type="number" step="0.01" name="numeric_price" value="{{ old('numeric_price') }}" class="w-full border rounded px-3 py-2">
                    <p class="text-xs text-gray-400 mt-1">Si tiene precio fijo, ponlo aquí para habilitar pago en línea.</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Imagen del Programa (opcional)</label>
                    <input type="file" name="image_file" accept="image/*"
                           class="w-full border rounded px-3 py-2 file:mr-3 file:py-2 file:px-4 file:rounded file:border-0 file:bg-[#DD2494] file:text-white file:font-bold file:cursor-pointer">
                    <p class="text-xs text-gray-400 mt-1">Sube una foto desde tu computadora (JPG o PNG, máx. 4MB).</p>

                    <div class="mt-3">
                        <label class="block text-gray-500 text-sm mb-1">…o pega una URL / ruta</label>
                        <input type="text" name="image_url" value="{{ old('image_url') }}" class="w-full border rounded px-3 py-2 text-sm" placeholder="/images/programas/mi-foto.jpg o https://...">
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

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Orden (menor número aparece primero)</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.programs.index') }}" class="text-gray-500 font-medium hover:underline">
                        Cancelar
                    </a>

                    <button type="submit"
                            style="background: linear-gradient(90deg, #DD2494 0%, #E65E0B 100%); color: white;"
                            class="px-6 py-3 rounded-lg font-bold shadow-lg hover:opacity-90 transition">
                        Guardar Programa
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
