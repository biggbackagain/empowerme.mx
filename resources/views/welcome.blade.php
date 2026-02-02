<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EmpowerMe Community</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Montserrat', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="text-2xl font-extrabold tracking-tighter">
                    EMPOWER<span class="text-pink-600">ME</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-900 font-bold hover:text-pink-600 transition">
                                Ir a mi Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-pink-600 font-bold transition hidden sm:block">
                                Iniciar Sesión
                            </a>
                            <a href="{{ route('register') }}" class="bg-pink-600 text-white px-5 py-2 rounded-full font-bold hover:bg-pink-700 transition shadow-md">
                                ¡Únete Gratis!
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <header class="relative bg-black h-[600px]">
        <img src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?auto=format&fit=crop&w=1950&q=80" class="absolute inset-0 w-full h-full object-cover opacity-50">
        
        <div class="relative max-w-7xl mx-auto py-40 px-4 text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight">
                Tu mejor versión <br> 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-orange-500">empieza hoy</span>
            </h1>
            <p class="text-xl text-gray-200 mb-10 max-w-2xl mx-auto font-medium">
                Únete a la comunidad que fusiona el fitness, el bienestar mental y la conexión social. Eventos exclusivos cada semana.
            </p>
            
            @auth
                <a href="#eventos" class="bg-white text-gray-900 px-8 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transition shadow-xl inline-block">
                    Ver Próximos Eventos ↓
                </a>
            @else
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="bg-pink-600 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-pink-700 transition shadow-xl transform hover:-translate-y-1">
                        Crear mi Cuenta Gratis
                    </a>
                    <a href="{{ route('login') }}" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-gray-900 transition">
                        Ya tengo cuenta
                    </a>
                </div>
            @endauth
        </div>
    </header>

    <section id="eventos" class="max-w-7xl mx-auto px-4 py-16">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Próximas Experiencias</h2>
                <p class="text-gray-500 mt-2">Explora, conecta y muévete con nosotros.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($events as $event)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-2xl transition duration-300 border border-gray-100">
                    <div class="h-56 overflow-hidden relative">
                        <img src="{{ $event->image_url ?? 'https://via.placeholder.com/400x300' }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-sm font-bold shadow text-gray-800">
                            📅 {{ $event->start_date->format('d M') }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $event->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $event->description }}</p>
                        
                        <div class="flex justify-between items-center border-t pt-4 mt-4">
                            <span class="text-sm text-gray-500">
                                {{ $event->participants->count() }} / {{ $event->capacity }} cupos
                            </span>
                            <a href="{{ route('event.detail', $event->id) }}" class="text-pink-600 font-bold hover:underline text-sm">
                                Ver Detalles →
                            </a>
                        </div>

                        <a href="{{ route('event.detail', $event->id) }}" class="block w-full text-center bg-gray-900 text-white py-3 rounded-xl font-bold mt-4 hover:bg-pink-600 transition shadow-lg">
                            Reservar Lugar
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20 bg-gray-50 rounded-2xl">
                    <p class="text-gray-400 text-xl">Próximamente publicaremos nuevos eventos.</p>
                </div>
            @endforelse
        </div>
    </section>

    <section class="bg-white py-20 border-t">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="relative">
                    <div class="absolute -inset-4 bg-pink-100 rounded-full blur-xl opacity-70"></div>
                    <img src="{{ asset('images/lizbethLozano_avatar.jpg') }}" class="relative rounded-3xl shadow-2xl w-full object-cover h-[500px]">
                </div>
                
                <div>
                    <span class="text-pink-600 font-bold tracking-wider uppercase text-sm">Nuestra Comunidad</span>
                    <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-6">Más que ejercicio, somos <span class="text-pink-600">Familia</span></h2>
                    
                    <p class="text-gray-600 text-lg leading-relaxed mb-6">
                        Hola, soy <strong>Liz Lozano</strong>. Como coach de vida, ayudo a las personas a reconectar con su propósito, alcanzar metas significativas y liberar todo su potencial.

He creado experiencias presenciales de empoderamiento que combinan la activación de la mentalidad y el liderazgo.

Recientemente fui galardonada con un premio al Bienestar Integral de la Mujer 2025 y he impartido conferencias en universidades para inspirar a estudiantes y profesionales a liderar desde la autenticidad y el propósito.

¿Qué puedes esperar al trabajar conmigo? Claridad, dirección y la energía para activar tu mejor versión.
                    </p>
                    
                    @guest
                        <div class="mt-8">
                            <p class="text-gray-900 font-bold mb-3">¿Lista para empezar?</p>
                            <a href="{{ route('register') }}" class="inline-block bg-pink-600 text-white px-8 py-3 rounded-full font-bold hover:bg-pink-700 transition shadow-lg">
                                Crear cuenta gratuita
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-12 text-center mt-12">
        <h3 class="text-2xl font-bold mb-4">EMPOWER<span class="text-pink-500">ME</span></h3>
        <p class="text-gray-400">Ciudad Guzmán, Jalisco, México.</p>
        <p class="text-gray-600 text-sm mt-8">&copy; {{ date('Y') }} Todos los derechos reservados.</p>
    </footer>

</body>
</html>