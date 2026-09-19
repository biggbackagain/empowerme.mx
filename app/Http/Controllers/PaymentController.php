<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Program;
use App\Models\ProgramPayment;
use App\Mail\EventTicketMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /* ============================================================
     |  EVENTOS
     ============================================================ */

    // Crea la preferencia de pago en Mercado Pago y redirige al checkout
    public function createEventPayment($eventId)
    {
        $event = Event::findOrFail($eventId);
        $user = Auth::user();

        // Si el evento ya pasó, no dejamos pagar
        if ($event->start_date->isPast()) {
            return redirect()->route('event.detail', $event->id)
                ->with('error', 'El registro para este evento ya cerró porque el evento finalizó.');
        }

        // Si ya está inscrito, lo mandamos a su boleto
        if ($event->participants->contains($user->id)) {
            return redirect()->route('event.detail', $event->id)
                ->with('error', 'Ya te habías inscrito anteriormente a este evento.');
        }

        // Si no tiene precio, no debería pasar por aquí: inscripción directa
        if (!$event->price || $event->price <= 0) {
            return redirect()->route('event.detail', $event->id)
                ->with('error', 'Este evento es gratuito, no requiere pago.');
        }

        $preference = $this->crearPreferencia(
            titulo: $event->title,
            monto: (float) $event->price,
            user: $user,
            backUrls: [
                'success' => route('payment.event.success', $event->id),
                'failure' => route('payment.event.failure', $event->id),
                'pending' => route('payment.event.pending', $event->id),
            ],
            externalReference: "event-{$event->id}-user-{$user->id}"
        );

        if (!$preference) {
            return redirect()->route('event.detail', $event->id)
                ->with('error', 'No pudimos conectar con Mercado Pago. Intenta de nuevo en un momento.');
        }

        // Guardamos en sesión qué está pagando, para poder confirmar manualmente
        // si Mercado Pago no regresa al sitio (típico en localhost sin dominio público).
        session(['pago_pendiente' => ['tipo' => 'evento', 'id' => $event->id]]);

        return redirect()->away($preference['init_point']);
    }

    // Página de confirmación manual: para cuando Mercado Pago NO regresa al sitio
    // (localhost sin dominio público). La persona pagó y aquí confirma para
    // generar su código e inscripción. En producción el regreso es automático
    // y esta pantalla casi nunca se usa.
    public function confirmarInscripcion()
    {
        $pendiente = session('pago_pendiente');

        if (!$pendiente || $pendiente['tipo'] !== 'evento') {
            return redirect()->route('dashboard')
                ->with('error', 'No hay ninguna inscripción pendiente por confirmar.');
        }

        $event = Event::find($pendiente['id']);
        if (!$event) {
            return redirect()->route('dashboard')->with('error', 'No encontramos el evento.');
        }

        return view('events.confirmar', ['event' => $event]);
    }

    // Ejecuta la inscripción tras confirmar manualmente el pago
    public function confirmarInscripcionPost(Request $request)
    {
        $pendiente = session('pago_pendiente');

        if (!$pendiente || $pendiente['tipo'] !== 'evento') {
            return redirect()->route('dashboard')
                ->with('error', 'No hay ninguna inscripción pendiente por confirmar.');
        }

        session()->forget('pago_pendiente');

        // Reutilizamos exactamente la misma lógica del retorno exitoso
        return $this->eventPaymentSuccess($request, $pendiente['id']);
    }

    // Retorno exitoso desde Mercado Pago (auto_return o botón "Volver al sitio")
    public function eventPaymentSuccess(Request $request, $eventId)
    {
        session()->forget('pago_pendiente');

        $event = Event::findOrFail($eventId);
        $user = Auth::user();

        // Evitar doble inscripción
        if ($event->participants->contains($user->id)) {
            $registro = $event->participants()->where('users.id', $user->id)->first();
            $code = $registro->pivot->confirmation_code;
            return redirect()->route('events.ticket', ['event' => $event->id, 'code' => $code]);
        }

        $code = $this->generarCodigo();

        $event->participants()->attach($user->id, [
            'confirmation_code' => $code,
            'payment_status' => 'approved',
            'payment_id' => $request->query('payment_id'),
        ]);

        try {
            Mail::to($user->email)->send(new EventTicketMail($event, $user, $code));
        } catch (\Throwable $e) {
            Log::warning('No se pudo enviar el correo del ticket: ' . $e->getMessage());
        }

        return redirect()
            ->route('events.ticket', ['event' => $event->id, 'code' => $code])
            ->with('success', '¡Pago aprobado! Tu lugar está confirmado. Tu código es ' . $code);
    }

    public function eventPaymentFailure(Request $request, $eventId)
    {
        return redirect()->route('event.detail', $eventId)
            ->with('error', 'El pago no se completó. No se realizó ningún cargo. Puedes intentarlo de nuevo.');
    }

    public function eventPaymentPending(Request $request, $eventId)
    {
        return redirect()->route('event.detail', $eventId)
            ->with('error', 'Tu pago quedó pendiente de confirmación. En cuanto Mercado Pago lo apruebe, tu lugar quedará reservado.');
    }

    /* ============================================================
     |  PROGRAMAS EMPRESARIALES
     ============================================================ */

    public function createProgramPayment($programId)
    {
        $program = Program::findOrFail($programId);
        $user = Auth::user();

        if (!$program->numeric_price || $program->numeric_price <= 0) {
            return redirect()->route('programs.show', $program->slug)
                ->with('error', 'Este programa no tiene pago en línea. Contáctanos para cotizar.');
        }

        $preference = $this->crearPreferencia(
            titulo: $program->title,
            monto: (float) $program->numeric_price,
            user: $user,
            backUrls: [
                'success' => route('payment.program.success', $program->id),
                'failure' => route('payment.program.failure', $program->id),
                'pending' => route('payment.program.pending', $program->id),
            ],
            externalReference: "program-{$program->id}-user-{$user->id}"
        );

        if (!$preference) {
            return redirect()->route('programs.show', $program->slug)
                ->with('error', 'No pudimos conectar con Mercado Pago. Intenta de nuevo en un momento.');
        }

        return redirect()->away($preference['init_point']);
    }

    public function programPaymentSuccess(Request $request, $programId)
    {
        $program = Program::findOrFail($programId);
        $user = Auth::user();

        ProgramPayment::create([
            'program_id' => $program->id,
            'user_id' => $user->id,
            'payment_id' => $request->query('payment_id'),
            'status' => 'approved',
            'amount' => $program->numeric_price,
        ]);

        return redirect()->route('programs.show', $program->slug)
            ->with('success', '¡Pago aprobado! Nos pondremos en contacto contigo para coordinar el programa "' . $program->title . '".');
    }

    public function programPaymentFailure(Request $request, $programId)
    {
        $program = Program::findOrFail($programId);
        return redirect()->route('programs.show', $program->slug)
            ->with('error', 'El pago no se completó. No se realizó ningún cargo. Puedes intentarlo de nuevo.');
    }

    public function programPaymentPending(Request $request, $programId)
    {
        $program = Program::findOrFail($programId);
        return redirect()->route('programs.show', $program->slug)
            ->with('error', 'Tu pago quedó pendiente de confirmación por Mercado Pago.');
    }

    /* ============================================================
     |  HELPERS
     ============================================================ */

    // Crea una preferencia de Checkout Pro vía la API de Mercado Pago.
    // Devuelve el arreglo de respuesta (con init_point) o null si falla.
    private function crearPreferencia(string $titulo, float $monto, $user, array $backUrls, string $externalReference): ?array
    {
        $token = config('mercadopago.access_token');

        if (empty($token)) {
            Log::error('MERCADOPAGO_ACCESS_TOKEN no está configurado.');
            return null;
        }

        try {
            $payload = [
                'items' => [[
                    'title' => $titulo,
                    'quantity' => 1,
                    'unit_price' => $monto,
                    'currency_id' => config('mercadopago.currency', 'MXN'),
                ]],
                'payer' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'back_urls' => $backUrls,
                'external_reference' => $externalReference,
                'notification_url' => route('payment.webhook'),
            ];

            // auto_return solo funciona con URLs públicas https.
            // En local (http/localhost) NO lo enviamos: Mercado Pago mostrará
            // un botón "Volver al sitio" que regresa a la página con el código.
            $successUrl = $backUrls['success'] ?? '';
            $esPublicaHttps = str_starts_with($successUrl, 'https://')
                && !str_contains($successUrl, 'localhost')
                && !str_contains($successUrl, '127.0.0.1');

            if ($esPublicaHttps) {
                $payload['auto_return'] = 'approved';
            }

            $response = Http::withToken($token)
                ->acceptJson()
                ->post('https://api.mercadopago.com/checkout/preferences', $payload);

            if ($response->failed()) {
                Log::error('Mercado Pago respondió con error: ' . $response->body());
                return null;
            }

            return $response->json();
        } catch (\Throwable $e) {
            Log::error('Error creando preferencia de Mercado Pago: ' . $e->getMessage());
            return null;
        }
    }

    /* ============================================================
     |  WEBHOOK (notificación automática de Mercado Pago)
     ============================================================ */

    // Mercado Pago llama a esta URL cuando cambia el estado de un pago.
    // Es la garantía de que la inscripción se complete AUNQUE el usuario
    // cierre el navegador antes de regresar. No depende de sesión ni de login.
    public function webhook(Request $request)
    {
        try {
            // MP manda el id del pago de varias formas según el evento
            $paymentId = $request->input('data.id')
                ?? $request->input('id')
                ?? $request->query('id')
                ?? $request->query('data_id');

            $tipo = $request->input('type') ?? $request->query('type') ?? $request->query('topic');

            // Solo nos interesan notificaciones de pago
            if ($tipo && !str_contains($tipo, 'payment')) {
                return response()->json(['ok' => true]);
            }

            if (!$paymentId) {
                return response()->json(['ok' => true]);
            }

            // Consultamos el pago real a la API de MP para confirmar su estado
            $token = config('mercadopago.access_token');
            $resp = Http::withToken($token)
                ->acceptJson()
                ->get("https://api.mercadopago.com/v1/payments/{$paymentId}");

            if ($resp->failed()) {
                Log::warning('Webhook MP: no se pudo consultar el pago ' . $paymentId);
                return response()->json(['ok' => true]);
            }

            $pago = $resp->json();

            // Solo procesamos pagos aprobados
            if (($pago['status'] ?? null) !== 'approved') {
                return response()->json(['ok' => true]);
            }

            $ref = $pago['external_reference'] ?? '';
            $this->procesarReferenciaPagada($ref, (string) $paymentId);

            return response()->json(['ok' => true]);
        } catch (\Throwable $e) {
            Log::error('Error en webhook de Mercado Pago: ' . $e->getMessage());
            // Devolvemos 200 igual, para que MP no reintente en bucle por un error nuestro
            return response()->json(['ok' => true]);
        }
    }

    // Inscribe / registra el pago a partir del external_reference
    // (formato: "event-{id}-user-{id}" o "program-{id}-user-{id}").
    // Idempotente: si ya está inscrito o ya existe el pago, no duplica.
    private function procesarReferenciaPagada(string $ref, string $paymentId): void
    {
        if (str_starts_with($ref, 'event-')) {
            // event-{eventId}-user-{userId}
            if (!preg_match('/^event-(\d+)-user-(\d+)$/', $ref, $m)) {
                return;
            }
            [$_, $eventId, $userId] = $m;
            $event = Event::find($eventId);
            $user = \App\Models\User::find($userId);
            if (!$event || !$user) {
                return;
            }

            // Ya inscrito: no duplicar
            if ($event->participants()->where('users.id', $user->id)->exists()) {
                return;
            }

            $code = $this->generarCodigo();
            $event->participants()->attach($user->id, [
                'confirmation_code' => $code,
                'payment_status' => 'approved',
                'payment_id' => $paymentId,
            ]);

            try {
                Mail::to($user->email)->send(new EventTicketMail($event, $user, $code));
            } catch (\Throwable $e) {
                Log::warning('Webhook: no se pudo enviar el correo del ticket: ' . $e->getMessage());
            }
        } elseif (str_starts_with($ref, 'program-')) {
            // program-{programId}-user-{userId}
            if (!preg_match('/^program-(\d+)-user-(\d+)$/', $ref, $m)) {
                return;
            }
            [$_, $programId, $userId] = $m;
            $program = Program::find($programId);
            $user = \App\Models\User::find($userId);
            if (!$program || !$user) {
                return;
            }

            // No duplicar el registro de pago
            $yaExiste = ProgramPayment::where('program_id', $program->id)
                ->where('user_id', $user->id)
                ->where('payment_id', $paymentId)
                ->exists();
            if ($yaExiste) {
                return;
            }

            ProgramPayment::create([
                'program_id' => $program->id,
                'user_id' => $user->id,
                'payment_id' => $paymentId,
                'status' => 'approved',
                'amount' => $program->numeric_price,
            ]);
        }
    }

    // Mismo generador de código que EventController (EM- + 5 chars sin confusos)
    private function generarCodigo(): string
    {
        $alfabeto = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

        do {
            $random = '';
            for ($i = 0; $i < 5; $i++) {
                $random .= $alfabeto[random_int(0, strlen($alfabeto) - 1)];
            }
            $code = 'EM-' . $random;
        } while (
            \DB::table('event_user')->where('confirmation_code', $code)->exists()
        );

        return $code;
    }
}
