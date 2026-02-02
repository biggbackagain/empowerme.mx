<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $event->title }} - EmpowerMe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Montserrat', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-extrabold tracking-tighter">
                EMPOWER<span class="text-pink-600">ME</span>
            </a>
            <div class="flex items-center space-x-4">
                <a href="{{ url('/') }}" class="text-gray-600 hover:text-pink-600 font-bold text-sm">← Volver al inicio</a>
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 mt-6">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md mb-4" role="alert">
                <p class="font-bold">¡Excelente!</p>
                <p>{{ session('success') }}</p>
                <a href="{{ route('dashboard') }}" class="underline text-sm">Ir a mis eventos</a>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md mb-4" role="alert">
                <p class="font-bold">Atención</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif
    </div>

    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            
            <div class="h-64 md:h-96 w-full relative">
                <img src="{{ $event->image_url ?? 'https://via.placeholder.com/800x400' }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-end">
                    <div class="p-8 text-white">
                        <h1 class="text-3xl md:text-5xl font-extrabold mb-2">{{ $event->title }}</h1>
                        <p class="text-xl font-medium flex items-center">
                            📍 {{ $event->location }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8 p-8">
                
                <div class="md:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Sobre este evento</h2>
                    <p class="text-gray-600 leading-relaxed text-lg whitespace-pre-line">
                        {{ $event->description }}
                    </p>

                    @if($event->recommendations)
                    <div class="mt-8 border-t pt-6">
                        <h3 class="font-bold text-lg mb-2 text-pink-600">📝 Recomendaciones:</h3>
                        <div class="bg-pink-50 p-4 rounded-lg border border-pink-100">
                            <p class="text-gray-700 whitespace-pre-line">{{ $event->recommendations }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div>
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 sticky top-24">
                        <div class="mb-6">
                            <p class="text-sm text-gray-500 uppercase font-bold">Fecha y Hora</p>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $event->start_date->format('d M, Y') }}
                            </p>
                            <p class="text-pink-600 font-bold">
                                {{ $event->start_date->format('h:i A') }}
                            </p>
                        </div>

                        <div class="mb-6">
                            <p class="text-sm text-gray-500 uppercase font-bold">Disponibilidad</p>
                            @php
                                $percent = ($event->participants->count() / $event->capacity) * 100;
                            @endphp
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                <div class="bg-pink-600 h-2.5 rounded-full" style="width: {{ $percent }}%"></div>
                            </div>
                            <p class="text-xs text-right mt-1 text-gray-500">
                                {{ $event->participants->count() }} / {{ $event->capacity }} inscritos
                            </p>
                        </div>

                        @auth
                            @if(Auth::user()->events->contains($event->id))
                                <button disabled class="w-full bg-green-100 text-green-700 py-3 rounded-xl font-bold border border-green-200 cursor-not-allowed">
                                    ✅ Ya estás inscrito
                                </button>
                                <a href="{{ route('dashboard') }}" class="block text-center text-sm text-gray-500 mt-2 hover:underline">Ver mi boleto</a>
                            
                            @elseif($event->participants->count() < $event->capacity)
                                <form action="{{ route('events.register', $event->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('¿Confirmas tu asistencia a {{ $event->title }}?');" class="w-full bg-pink-600 text-white py-3 rounded-xl font-bold hover:bg-pink-700 transition shadow-lg transform hover:-translate-y-1">
                                        ¡Quiero Inscribirme!
                                    </button>
                                </form>
                                <p class="text-xs text-center text-gray-400 mt-3">Al registrarte aceptas nuestros términos.</p>
                            
                            @else
                                <button disabled class="w-full bg-gray-300 text-gray-500 py-3 rounded-xl font-bold cursor-not-allowed">
                                    ⛔ Cupo Lleno
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block text-center w-full bg-gray-900 text-white py-3 rounded-xl font-bold hover:bg-gray-800 transition">
                                Inicia sesión para inscribirte
                            </a>
                            <p class="text-xs text-center text-gray-400 mt-3">¿No tienes cuenta? <a href="{{ route('register') }}" class="text-pink-600 underline">Regístrate gratis</a></p>
                        @endauth

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>