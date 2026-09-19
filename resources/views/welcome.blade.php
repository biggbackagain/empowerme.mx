<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EmpowerMe Community</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .em-gradient { background: linear-gradient(90deg, #DD2494 0%, #E65E0B 100%); }
        .em-gradient-text {
            background: linear-gradient(90deg, #DD2494 0%, #E65E0B 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
    </style>
</head>
<body class="bg-[#FBF6F1] text-[#111111]">

    <!-- ============ NAV ============ -->
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="#inicio" class="text-xl sm:text-2xl font-extrabold tracking-tighter flex-shrink-0 mr-2">
                    EMPOWER<span class="text-[#DD2494]">ME</span>
                </a>

                <div class="hidden xl:flex items-center space-x-6 text-sm font-bold text-[#111111] whitespace-nowrap">
                    <a href="#inicio" class="hover:text-[#E65E0B] transition">Inicio</a>
                    <a href="#quienes-somos" class="hover:text-[#E65E0B] transition">Quiénes Somos</a>
                    <a href="#experiencias" class="hover:text-[#E65E0B] transition">Experiencias</a>
                    <a href="#programas" class="hover:text-[#E65E0B] transition">Programas</a>
                    <a href="#comunidad" class="hover:text-[#E65E0B] transition">Comunidad</a>
                    <a href="#contacto" class="hover:text-[#E65E0B] transition">Contacto</a>
                </div>

                <div class="flex items-center space-x-2 sm:space-x-4 flex-shrink-0">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-[#111111] font-bold hover:text-[#DD2494] transition hidden sm:block whitespace-nowrap">
                                Ir a mi Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-[#111111] hover:text-[#DD2494] font-bold transition hidden sm:block whitespace-nowrap">
                                Iniciar Sesión
                            </a>
                            <a href="{{ route('register') }}" class="em-gradient text-white px-3 py-1.5 sm:px-5 sm:py-2 text-sm sm:text-base rounded-full font-bold hover:opacity-90 transition shadow-md whitespace-nowrap">
                                ¡Únete Gratis!
                            </a>
                        @endauth
                    @endif
                </div>
            </div>

            <!-- Nav móvil/tablet (scroll horizontal) -->
            <div class="xl:hidden flex space-x-6 overflow-x-auto text-sm font-bold text-[#111111] px-4 pb-3 -mt-1">
                <a href="#inicio" class="whitespace-nowrap hover:text-[#E65E0B]">Inicio</a>
                <a href="#quienes-somos" class="whitespace-nowrap hover:text-[#E65E0B]">Quiénes Somos</a>
                <a href="#experiencias" class="whitespace-nowrap hover:text-[#E65E0B]">Experiencias</a>
                <a href="#programas" class="whitespace-nowrap hover:text-[#E65E0B]">Programas</a>
                <a href="#comunidad" class="whitespace-nowrap hover:text-[#E65E0B]">Comunidad</a>
                <a href="#contacto" class="whitespace-nowrap hover:text-[#E65E0B]">Contacto</a>
            </div>
        </div>
    </nav>

    <!-- ============ INICIO / PORTADA ============ -->
    <header id="inicio" class="relative bg-[#111111] min-h-[600px] h-auto pb-16 md:pb-0 scroll-mt-16 overflow-hidden">

        @if($heroImages->count() > 0)
            {{-- Carrusel de fotos de las experiencias (se administra desde el panel) --}}
            <div id="hero-carousel" class="absolute inset-0">
                @foreach($heroImages as $i => $hero)
                    <img src="{{ $hero->image_url }}"
                         class="hero-slide absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 {{ $i === 0 ? 'opacity-40' : 'opacity-0' }}"
                         data-index="{{ $i }}">
                @endforeach
            </div>
        @else
            {{-- Sin fotos en el carrusel: usa la portada estática --}}
            <img src="{{ asset('images/portada-hero.jpg') }}" class="absolute inset-0 w-full h-full object-cover opacity-40">
        @endif

        <div class="relative max-w-7xl mx-auto py-40 px-4 text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight">
                Tu mejor versión <br>
                <span class="em-gradient-text">empieza hoy</span>
            </h1>
            <p class="text-xl text-gray-200 mb-10 max-w-2xl mx-auto font-medium">
                Únete a la comunidad que fusiona el fitness, el bienestar mental y la conexión social. Eventos exclusivos cada semana.
            </p>

            @auth
                <a href="#experiencias" class="bg-white text-[#111111] px-8 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transition shadow-xl inline-block">
                    Ver Próximos Eventos ↓
                </a>
            @else
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="em-gradient text-white px-8 py-4 rounded-full font-bold text-lg hover:opacity-90 transition shadow-xl transform hover:-translate-y-1">
                        Crear mi Cuenta Gratis
                    </a>
                    <a href="{{ route('login') }}" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-[#111111] transition">
                        Ya tengo cuenta
                    </a>
                </div>
            @endauth
        </div>
    </header>

    <!-- ============ QUIÉNES SOMOS ============ -->
    <section id="quienes-somos" class="max-w-7xl mx-auto px-4 py-20 scroll-mt-16">
        <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
            <div class="relative order-2 md:order-1">
                <div class="absolute -inset-4 bg-gradient-to-br from-[#DD2494]/10 to-[#E65E0B]/10 rounded-full blur-2xl"></div>
                <img src="{{ asset('images/quienes-somos.jpg') }}"
                     class="relative rounded-3xl shadow-2xl w-full object-cover h-[420px]">
                <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-xl px-6 py-4 hidden sm:block">
                    <p class="text-3xl font-extrabold em-gradient-text leading-none">100%</p>
                    <p class="text-xs text-gray-500 font-bold mt-1 uppercase tracking-wide">Bienestar Integral</p>
                </div>
            </div>

            <div class="order-1 md:order-2">
                <div class="w-14 h-1.5 em-gradient rounded-full mb-5"></div>
                <span class="text-[#DD2494] font-bold tracking-wider uppercase text-sm">Quiénes Somos</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-[#111111] mt-3 mb-6 leading-tight">
                    Programas y experiencias que <span class="em-gradient-text">activan tu potencial</span>
                </h2>
                <p class="text-gray-600 text-lg leading-relaxed">
                    Diseñamos programas y experiencias de bienestar que promueven la salud física, mental y emocional
                    a través de la activación física, el desarrollo humano y la comunidad, ayudando a las personas
                    a fortalecer su confianza, conectar con otros y activar su potencial.
                </p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6 mb-12">
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <h3 class="text-xl font-extrabold mb-3 text-[#DD2494]">Misión</h3>
                <p class="text-gray-600 leading-relaxed">
                    Impulsar el desarrollo humano y construir espacios donde las personas crean en sí mismas.
                </p>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <h3 class="text-xl font-extrabold mb-3 text-[#E65E0B]">Visión</h3>
                <p class="text-gray-600 leading-relaxed">
                    Consolidar a EMPOWERME como una empresa referente en bienestar integral, con presencia nacional,
                    reconocida por diseñar programas y experiencias que transforman vidas, empresas y comunidades.
                </p>
            </div>
        </div>

        <div>
            <h3 class="text-xl font-extrabold text-center mb-8">Nuestros Valores</h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $valores = [
                        ['t' => 'Bienestar integral', 'd' => 'Cuerpo, mente y emociones son igual de importantes. Lo valioso está en disfrutar cada experiencia.'],
                        ['t' => 'Comunidad', 'd' => 'Nadie avanza solo; celebramos el progreso colectivo tanto como el individual.'],
                        ['t' => 'Movimiento con propósito', 'd' => 'Te mueves desde el gozo, no como castigo.'],
                        ['t' => 'Autoconfianza', 'd' => 'No basta con decir "puedes": diseñamos experiencias donde activas tu potencial.'],
                        ['t' => 'Autenticidad', 'd' => 'Construimos espacios desde lo real, genuino y transparente.'],
                        ['t' => 'Disciplina', 'd' => 'Los hábitos se sostienen con estructura y acciones constantes. Creemos en ti.'],
                    ];
                @endphp
                @foreach ($valores as $valor)
                    <div class="rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition bg-white">
                        <div class="w-10 h-10 rounded-full em-gradient mb-4"></div>
                        <h4 class="font-bold text-[#111111] mb-2">{{ $valor['t'] }}</h4>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $valor['d'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============ EXPERIENCIAS ============ -->
    <section id="experiencias" class="bg-white py-20 border-t scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <span class="text-[#DD2494] font-bold tracking-wider uppercase text-sm">Experiencias</span>
                    <h2 class="text-3xl font-bold text-[#111111] mt-2">Próximas Experiencias</h2>
                    <p class="text-gray-500 mt-2">Explora, conecta y muévete con nosotros.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($events as $event)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-2xl transition duration-300 border border-gray-100">
                        <div class="h-56 overflow-hidden relative">
                            <img src="{{ $event->image_url ?? 'https://via.placeholder.com/400x300' }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" style="object-position: {{ $event->image_position ?? 'center' }};">
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-sm font-bold shadow text-[#111111]">
                                📅 {{ $event->start_date->format('d M') }}
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-[#111111] mb-2">{{ $event->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $event->description }}</p>

                            @if($event->price > 0)
                                <p class="text-lg font-extrabold em-gradient-text mb-2">${{ number_format($event->price, 2) }} MXN</p>
                            @else
                                <p class="text-sm font-bold text-green-600 mb-2">Evento gratuito</p>
                            @endif

                            <div class="flex justify-between items-center border-t pt-4 mt-4">
                                <span class="text-sm text-gray-500">
                                    {{ $event->participants->count() }} / {{ $event->capacity }} cupos
                                </span>
                                <a href="{{ route('event.detail', $event->id) }}" class="text-[#DD2494] font-bold hover:underline text-sm">
                                    Ver Detalles →
                                </a>
                            </div>

                            @if($event->price > 0)
                                <a href="{{ route('payment.event.create', $event->id) }}" class="flex items-center justify-center gap-2 w-full text-center em-gradient text-white py-3 rounded-xl font-bold mt-4 hover:opacity-90 transition shadow-lg">
                                    🛒 Inscribirme — ${{ number_format($event->price, 2) }} MXN
                                </a>
                            @else
                                <a href="{{ route('event.detail', $event->id) }}" class="flex items-center justify-center gap-2 w-full text-center bg-[#111111] text-white py-3 rounded-xl font-bold mt-4 hover:opacity-90 transition shadow-lg">
                                    🛒 Inscribirme
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-20 bg-[#FBF6F1] rounded-2xl">
                        <p class="text-gray-400 text-xl">Próximamente publicaremos nuevos eventos.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ============ PROGRAMAS EMPRESAS ============ -->
    <section id="programas" class="max-w-7xl mx-auto px-4 py-20 scroll-mt-16">
        <div class="mb-12">
            <span class="text-[#E65E0B] font-bold tracking-wider uppercase text-sm">Programas Empresas</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#111111] mt-2">
                MOVE YOUR <span class="em-gradient-text">COMPANY</span>
            </h2>
            <p class="text-gray-500 mt-2 max-w-2xl">
                Programas de bienestar diseñados para llevar el movimiento, la conexión y el desarrollo humano
                directamente a tu empresa.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @forelse ($programs as $programa)
                <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-100 bg-white flex flex-col">
                    @if($programa->image_url)
                        <div class="h-44 overflow-hidden">
                            <img src="{{ $programa->image_url }}" class="w-full h-full object-cover" style="object-position: {{ $programa->image_position ?? 'center' }};">
                        </div>
                    @else
                        <div class="h-3 em-gradient"></div>
                    @endif
                    <div class="p-8 flex flex-col flex-1">
                        <h3 class="text-xl font-bold text-[#111111] mb-3">{{ $programa->title }}</h3>
                        <p class="text-gray-600 leading-relaxed mb-6 flex-1 line-clamp-4">{{ $programa->summary }}</p>
                        @if($programa->numeric_price > 0)
                            <p class="text-lg font-extrabold em-gradient-text mb-4">${{ number_format($programa->numeric_price, 2) }} MXN</p>
                        @endif
                        <a href="{{ route('programs.show', $programa->slug) }}" class="inline-block text-center border-2 border-[#DD2494] text-[#DD2494] px-6 py-3 rounded-full font-bold hover:bg-[#DD2494] hover:text-white transition">
                            Conoce más
                        </a>
                    </div>
                </div>
            @empty
                {{-- Contenido de respaldo mientras se cargan los programas desde el panel --}}
                @foreach ([
                    ['t' => 'Wellness Day', 'd' => 'Una experiencia de bienestar diseñada para romper la rutina, activar a tu equipo y fortalecer sus conexiones a través del movimiento.'],
                    ['t' => 'Empowerme 30', 'd' => 'Un programa de 30 días que impulsa hábitos saludables, constancia y comunidad, motivando a cada colaborador a moverse, conectar y descubrir de lo que es capaz.'],
                    ['t' => 'Team Experience', 'd' => 'Una experiencia de integración donde el movimiento y los retos colaborativos se convierten en herramientas para fortalecer la comunicación, la confianza y el trabajo en equipo.'],
                ] as $fallback)
                    <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-100 bg-white flex flex-col">
                        <div class="h-3 em-gradient"></div>
                        <div class="p-8 flex flex-col flex-1">
                            <h3 class="text-xl font-bold text-[#111111] mb-3">{{ $fallback['t'] }}</h3>
                            <p class="text-gray-600 leading-relaxed mb-6 flex-1">{{ $fallback['d'] }}</p>
                            <a href="#contacto" class="inline-block text-center border-2 border-[#DD2494] text-[#DD2494] px-6 py-3 rounded-full font-bold hover:bg-[#DD2494] hover:text-white transition">
                                Conoce más
                            </a>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </section>

    <!-- ============ COMUNIDAD E IMPACTO SOCIAL ============ -->
    <section id="comunidad" class="bg-white py-20 border-t scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="relative">
                    <div class="absolute -inset-4 bg-[#DD2494]/10 rounded-full blur-xl opacity-70"></div>
                    <img src="{{ asset('images/lizbethLozano_avatar.jpg') }}" class="relative rounded-3xl shadow-2xl w-full object-cover h-[500px]">
                </div>

                <div>
                    <span class="text-[#DD2494] font-bold tracking-wider uppercase text-sm">Comunidad e Impacto Social</span>
                    <h2 class="text-4xl font-extrabold text-[#111111] mt-2 mb-6">Más que ejercicio, somos <span class="text-[#DD2494]">Familia</span></h2>

                    <p class="text-gray-600 text-lg leading-relaxed mb-6">
                        <strong>Lizbeth Lozano</strong> es fundadora y directora de Empowerme. Ingeniera en Gestión Empresarial,
                        Project Manager y Coach, ha enfocado su trayectoria en el desarrollo humano, el liderazgo y la
                        creación de proyectos que generan un impacto positivo en las personas.
                        <br><br>
                        En 2023 fundó Empowerme con la visión de crear espacios donde el bienestar, el movimiento y la
                        conexión humana se convirtieran en herramientas para fortalecer la confianza y el desarrollo
                        personal. Desde entonces, ha liderado el diseño y ejecución de experiencias, programas y alianzas
                        que han permitido que Empowerme evolucione de una iniciativa enfocada en mujeres a una empresa de
                        bienestar con impacto en personas, comunidades y organizaciones.
                        <br><br>
                        Su trabajo ha sido reconocido con la <strong>Presea María Elena Larios 2025</strong>, en la categoría
                        de Bienestar Integral de la Mujer, y como finalista del <strong>Premio Emprendedor Jalisco 2026</strong>.
                        <br><br>
                        Hoy, su visión es consolidar a Empowerme como una empresa capaz de demostrar que el bienestar puede
                        generar al mismo tiempo impacto humano, valor para las organizaciones y crecimiento sostenible.
                    </p>

                    @guest
                        <div class="mt-8">
                            <p class="text-[#111111] font-bold mb-3">¿Lista para empezar?</p>
                            <a href="{{ route('register') }}" class="inline-block em-gradient text-white px-8 py-3 rounded-full font-bold hover:opacity-90 transition shadow-lg">
                                Crear cuenta gratuita
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CONTACTO ============ -->
    <section id="contacto" class="max-w-4xl mx-auto px-4 py-20 scroll-mt-16">
        <div class="text-center mb-10">
            <span class="text-[#E65E0B] font-bold tracking-wider uppercase text-sm">Contacto</span>
            <h2 class="text-3xl font-bold text-[#111111] mt-2">Compártenos ¿Cómo podemos ayudarte?</h2>
        </div>

        @if (session('contact_success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl text-center font-medium">
                {{ session('contact_success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('contact.store') }}" class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-bold text-[#111111] mb-2">Nombre completo</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full rounded-xl border-gray-300 focus:border-[#DD2494] focus:ring-[#DD2494] px-4 py-3"
                    placeholder="Tu nombre completo">
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-[#111111] mb-2">Email de la empresa</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="w-full rounded-xl border-gray-300 focus:border-[#DD2494] focus:ring-[#DD2494] px-4 py-3"
                    placeholder="correo@empresa.com">
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="message" class="block text-sm font-bold text-[#111111] mb-2">Compártenos ¿Cómo podemos ayudarte?</label>
                <textarea name="message" id="message" rows="5"
                    class="w-full rounded-xl border-gray-300 focus:border-[#DD2494] focus:ring-[#DD2494] px-4 py-3"
                    placeholder="Cuéntanos qué necesitas...">{{ old('message', request('programa') ? 'Me interesa el programa: ' . request('programa') . '. ' : '') }}</textarea>
                @error('message')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full em-gradient text-white py-4 rounded-full font-bold text-lg hover:opacity-90 transition shadow-lg">
                Enviar
            </button>
        </form>
    </section>

    <!-- ============ FOOTER ============ -->
    <footer class="bg-[#111111] text-white py-12 text-center mt-12">
        <h3 class="text-2xl font-bold mb-4">EMPOWER<span class="text-[#DD2494]">ME</span></h3>
        <p class="text-gray-400">Ciudad Guzmán, Jalisco, México.</p>
        <p class="text-gray-600 text-sm mt-8">&copy; {{ date('Y') }} Todos los derechos reservados.</p>
    </footer>

    @if($heroImages->count() > 1)
    <script>
        // Carrusel del hero: rota las fotos cada 5 segundos
        (function () {
            const slides = document.querySelectorAll('#hero-carousel .hero-slide');
            if (slides.length < 2) return;
            let actual = 0;
            setInterval(function () {
                slides[actual].classList.remove('opacity-40');
                slides[actual].classList.add('opacity-0');
                actual = (actual + 1) % slides.length;
                slides[actual].classList.remove('opacity-0');
                slides[actual].classList.add('opacity-40');
            }, 5000);
        })();
    </script>
    @endif

</body>
</html>
