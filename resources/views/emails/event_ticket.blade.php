<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tu código EmpowerMe</title>
</head>
<body style="margin:0; padding:0; background:#FBF6F1; font-family: Arial, Helvetica, sans-serif; color:#111111;">
    <div style="max-width:520px; margin:0 auto; padding:24px;">
        <div style="background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.08);">

            <div style="background:linear-gradient(90deg,#DD2494 0%,#E65E0B 100%); padding:24px; text-align:center;">
                <div style="font-size:22px; font-weight:bold; color:#ffffff; letter-spacing:-0.5px;">EMPOWER<span style="opacity:.85;">ME</span></div>
            </div>

            <div style="padding:28px;">
                <p style="font-size:16px; margin:0 0 8px;">¡Hola {{ $user->name }}!</p>
                <p style="font-size:15px; color:#444; margin:0 0 20px;">
                    Tu lugar en <strong>{{ $event->title }}</strong> está confirmado. Este es tu código de acceso:
                </p>

                <div style="background:#FBF6F1; border:2px dashed #DD2494; border-radius:12px; padding:20px; text-align:center; margin-bottom:20px;">
                    <div style="font-size:12px; text-transform:uppercase; color:#888; letter-spacing:1px;">Tu código</div>
                    <div style="font-size:34px; font-weight:bold; letter-spacing:3px; color:#DD2494; margin-top:4px;">{{ $code }}</div>
                </div>

                <table style="width:100%; font-size:14px; color:#333; border-collapse:collapse;">
                    <tr><td style="padding:4px 0; color:#888;">Evento</td><td style="padding:4px 0; text-align:right; font-weight:bold;">{{ $event->title }}</td></tr>
                    <tr><td style="padding:4px 0; color:#888;">Fecha</td><td style="padding:4px 0; text-align:right;">{{ $event->start_date->translatedFormat('d M, Y') }}</td></tr>
                    <tr><td style="padding:4px 0; color:#888;">Hora</td><td style="padding:4px 0; text-align:right;">{{ $event->start_date->translatedFormat('h:i A') }}</td></tr>
                    <tr><td style="padding:4px 0; color:#888;">Lugar</td><td style="padding:4px 0; text-align:right;">{{ $event->location }}</td></tr>
                </table>

                <p style="font-size:13px; color:#888; margin:22px 0 0; text-align:center;">
                    Muestra este código el día del evento para confirmar tu asistencia.
                </p>
            </div>
        </div>
        <p style="text-align:center; font-size:12px; color:#aaa; margin-top:16px;">EmpowerMe Community</p>
    </div>
</body>
</html>
