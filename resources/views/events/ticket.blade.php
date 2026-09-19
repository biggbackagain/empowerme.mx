<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi boleto - {{ $event->title }} - EmpowerMe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .em-gradient { background: linear-gradient(90deg, #DD2494 0%, #E65E0B 100%); }
        @media print {
            .no-print { display: none !important; }
            body { background: #ffffff !important; }
        }
    </style>
</head>
<body class="bg-[#FBF6F1] text-[#111111] min-h-screen py-10 px-4">

    <div class="max-w-md mx-auto">

        @if(session('success'))
            <div class="no-print bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- TICKET -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="em-gradient p-6 text-center text-white">
                <div class="text-2xl font-extrabold tracking-tighter">EMPOWER<span class="opacity-80">ME</span></div>
                <p class="text-sm text-white/80 mt-1">Boleto de acceso</p>
            </div>

            @if($event->image_url)
                <div class="h-40 w-full overflow-hidden">
                    <img src="{{ $event->image_url }}" class="w-full h-full object-cover" style="object-position: {{ $event->image_position ?? 'center' }};">
                </div>
            @endif

            <div class="p-8">
                <h1 class="text-2xl font-extrabold mb-1">{{ $event->title }}</h1>
                <p class="text-gray-500 mb-6">{{ $event->location }}</p>

                <!-- CÓDIGO -->
                <div class="bg-[#FBF6F1] border-2 border-dashed border-[#DD2494] rounded-2xl p-6 text-center mb-6">
                    <p class="text-xs uppercase tracking-widest text-gray-500">Tu código</p>
                    <p class="text-4xl font-extrabold tracking-widest text-[#DD2494] mt-1">{{ $code }}</p>
                </div>

                <div class="space-y-3 border-t pt-5 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Nombre</span>
                        <span class="font-bold">{{ $user->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Fecha</span>
                        <span class="font-bold">{{ $event->start_date->translatedFormat('d M, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Hora</span>
                        <span class="font-bold">{{ $event->start_date->translatedFormat('h:i A') }}</span>
                    </div>
                </div>

                <p class="text-xs text-center text-gray-400 mt-6">
                    Muestra este código el día del evento para confirmar tu asistencia.
                </p>
            </div>
        </div>

        <!-- BOTONES (no salen al imprimir) -->
        <div class="no-print mt-6 flex flex-col gap-3">
            <button onclick="window.print()" class="w-full em-gradient text-white py-3 rounded-xl font-bold shadow-lg hover:opacity-90 transition">
                🖨️ Imprimir / Guardar como PDF
            </button>
            <a href="{{ route('dashboard') }}" class="w-full text-center bg-white border border-gray-200 py-3 rounded-xl font-bold text-gray-700 hover:bg-gray-50 transition">
                Ir a mi panel
            </a>
        </div>
    </div>

</body>
</html>
