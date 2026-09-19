<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Carrusel de fotos del inicio
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl font-medium">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl font-medium">{{ session('error') }}</div>
            @endif

            {{-- Subir nueva foto --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold mb-1">Agregar foto al carrusel</h3>
                <p class="text-sm text-gray-500 mb-4">Estas fotos rotan en el fondo del inicio, donde dice "Tu mejor versión".</p>

                <form action="{{ route('admin.hero.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Foto (desde tu computadora)</label>
                        <input type="file" name="image_file" accept="image/*"
                               class="w-full border rounded px-3 py-2 file:mr-3 file:py-2 file:px-4 file:rounded file:border-0 file:bg-[#DD2494] file:text-white file:font-bold file:cursor-pointer">
                        <p class="text-xs text-gray-400 mt-1">JPG o PNG, máx. 6MB. Se ven mejor las fotos horizontales (apaisadas).</p>
                    </div>
                    <div>
                        <label class="block text-gray-500 text-sm mb-1">…o pega una URL / ruta</label>
                        <input type="text" name="image_url" class="w-full border rounded px-3 py-2 text-sm" placeholder="/images/... o https://...">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Orden (menor aparece primero)</label>
                        <input type="number" name="order" value="0" class="w-32 border rounded px-3 py-2">
                    </div>
                    <button type="submit" style="background: linear-gradient(90deg,#DD2494 0%,#E65E0B 100%); color:white;"
                            class="px-6 py-3 rounded-lg font-bold shadow hover:opacity-90 transition">Agregar foto</button>
                </form>
            </div>

            {{-- Fotos actuales --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Fotos del carrusel</h3>

                @if($images->isEmpty())
                    <p class="text-gray-500 italic text-center py-10">Todavía no hay fotos. Mientras tanto se muestra la portada estática.</p>
                @else
                    <div class="grid sm:grid-cols-2 gap-4">
                        @foreach($images as $img)
                        <div class="border rounded-xl overflow-hidden {{ $img->active ? '' : 'opacity-50' }}">
                            <img src="{{ $img->image_url }}" class="w-full h-40 object-cover">
                            <div class="p-3 flex justify-between items-center">
                                <span class="text-xs text-gray-500">Orden: {{ $img->order }} · {{ $img->active ? 'Activa' : 'Oculta' }}</span>
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.hero.toggle', $img->id) }}" method="POST">
                                        @csrf
                                        <button class="text-[#E65E0B] font-bold text-sm">{{ $img->active ? 'Ocultar' : 'Activar' }}</button>
                                    </form>
                                    <form action="{{ route('admin.hero.destroy', $img->id) }}" method="POST" onsubmit="return confirm('¿Borrar esta foto?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 text-sm">Borrar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
