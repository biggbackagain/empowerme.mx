<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmar inscripción - EmpowerMe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .em-gradient { background: linear-gradient(90deg, #DD2494 0%, #E65E0B 100%); }
    </style>
</head>
<body class="bg-[#FBF6F1] text-[#111111] min-h-screen flex items-center justify-center py-10 px-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl overflow-hidden">
        <div class="em-gradient p-6 text-center text-white">
            <div class="text-2xl font-extrabold tracking-tighter">EMPOWER<span class="opacity-80">ME</span></div>
        </div>

        <div class="p-8 text-center">
            <div class="text-5xl mb-4">💳</div>
            <h1 class="text-2xl font-extrabold mb-2">¿Ya completaste tu pago?</h1>
            <p class="text-gray-600 mb-1">Evento: <strong>{{ $event->title }}</strong></p>
            <p class="text-gray-500 text-sm mb-6">
                Si tu pago en Mercado Pago fue aprobado, confirma aquí para generar tu código de acceso.
            </p>

            <form action="{{ route('payment.confirm.post') }}" method="POST">
                @csrf
                <button type="submit"
                        class="w-full em-gradient text-white py-4 rounded-xl font-bold hover:opacity-90 transition shadow-lg mb-3">
                    ✅ Ya pagué, confirmar mi inscripción
                </button>
            </form>

            <a href="{{ route('event.detail', $event->id) }}" class="block text-center text-sm text-gray-500 hover:underline">
                Todavía no pago, volver al evento
            </a>

            <p class="text-xs text-gray-400 mt-6 border-t pt-4">
                Nota: en el sitio publicado, Mercado Pago te traerá de vuelta automáticamente y esta pantalla no será necesaria.
            </p>
        </div>
    </div>

</body>
</html>
