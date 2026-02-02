<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo Evento
        </h2>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">
            
            <form action="{{ route('admin.store') }}" method="POST">
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
                    <label class="block text-gray-700 font-bold mb-2">URL de la Imagen (Opcional)</label>
                    <input type="url" name="image_url" placeholder="https://..." class="w-full border rounded px-3 py-2">
                </div>

                <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100">
                    <a href="{{ route('dashboard') }}" class="text-gray-500 font-medium hover:underline">
                        Cancelar
                    </a>

                    <button type="submit" 
                            style="background-color: #db2777; color: white;"
                            class="px-6 py-3 rounded-lg font-bold shadow-lg hover:opacity-90 transition">
                        Guardar Evento
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>