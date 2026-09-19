<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $program->title }} - EmpowerMe</title>
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

    <nav class="bg-white shadow p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-extrabold tracking-tighter">
                EMPOWER<span class="text-[#DD2494]">ME</span>
            </a>
            <a href="{{ url('/') }}#programas" class="text-[#111111] hover:text-[#DD2494] font-bold text-sm">← Volver a Programas</a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-10">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

            <div class="h-64 md:h-96 w-full relative">
                <img src="{{ $program->image_url ?? 'https://via.placeholder.com/1200x600' }}" class="w-full h-full object-cover" style="object-position: {{ $program->image_position ?? 'center' }};">
                <div class="absolute inset-0 bg-black/40 flex items-end">
                    <div class="p-8 text-white">
                        <span class="text-sm font-bold uppercase tracking-wider text-white/80">Move Your Company</span>
                        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight">{{ $program->title }}</h1>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8 p-8">

                <div class="md:col-span-2">
                    <h2 class="text-2xl font-bold mb-4">Sobre este programa</h2>
                    <p class="text-gray-600 leading-relaxed text-lg whitespace-pre-line">
                        {{ $program->summary }}
                    </p>

                    @if(!empty($program->includes_list))
                        <div class="mt-8 border-t pt-6">
                            <h3 class="font-bold text-lg mb-4 text-[#DD2494]">Qué incluye</h3>
                            <ul class="space-y-3">
                                @foreach($program->includes_list as $item)
                                    <li class="flex items-start gap-3">
                                        <span class="flex-shrink-0 w-5 h-5 rounded-full em-gradient flex items-center justify-center mt-0.5">
                                            <span class="text-white text-xs font-bold">✓</span>
                                        </span>
                                        <span class="text-gray-700">{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div>
                    <div class="bg-[#FBF6F1] p-6 rounded-2xl border border-gray-200 sticky top-24">
                        @if($program->numeric_price > 0)
                            <p class="text-sm text-gray-500 uppercase font-bold mb-1">Inversión</p>
                            <p class="text-2xl font-extrabold em-gradient-text mb-6">
                                ${{ number_format($program->numeric_price, 2) }} MXN
                            </p>

                            @auth
                                <a href="{{ route('payment.program.create', $program->id) }}"
                                   class="block text-center w-full em-gradient text-white py-4 rounded-xl font-bold hover:opacity-90 transition shadow-lg transform hover:-translate-y-0.5">
                                    Pagar en línea
                                </a>
                                <p class="text-xs text-center text-gray-400 mt-3">
                                    Serás dirigido al pago seguro en línea.
                                </p>
                            @else
                                <a href="{{ route('login') }}"
                                   class="block text-center w-full bg-gray-900 text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition">
                                    Inicia sesión para pagar
                                </a>
                                <p class="text-xs text-center text-gray-400 mt-3">
                                    ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-[#DD2494] underline">Regístrate gratis</a>
                                </p>
                            @endauth
                        @else
                            <p class="text-sm text-gray-500 uppercase font-bold mb-1">Inversión</p>
                            <p class="text-2xl font-extrabold em-gradient-text mb-6">
                                {{ $program->price ?? 'Cotiza con nosotros' }}
                            </p>

                            <a href="{{ url('/') }}?programa={{ urlencode($program->title) }}#contacto"
                               class="block text-center w-full em-gradient text-white py-4 rounded-xl font-bold hover:opacity-90 transition shadow-lg transform hover:-translate-y-0.5">
                                Apartar este programa
                            </a>
                            <p class="text-xs text-center text-gray-400 mt-3">
                                Te llevamos al formulario de contacto con este programa preseleccionado.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-10">
            <a href="{{ url('/') }}#programas" class="text-[#DD2494] font-bold hover:underline">← Ver los demás programas</a>
        </div>
    </div>

</body>
</html>
