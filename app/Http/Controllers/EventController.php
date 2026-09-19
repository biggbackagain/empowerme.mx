<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Mail\EventTicketMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    // Función para registrar al usuario en el evento
    public function register($id)
    {
        $event = Event::findOrFail($id);
        $user = Auth::user();

        // 0. Validar que el evento no haya finalizado
        if ($event->start_date->isPast()) {
            return back()->with('error', 'El registro para este evento ya cerró porque el evento finalizó.');
        }

        // 1. Validar si ya está inscrito
        if ($event->participants->contains($user->id)) {
            return back()->with('error', 'Ya te habías inscrito anteriormente a este evento.');
        }

        // 2. Validar si hay cupo
        if ($event->participants()->count() >= $event->capacity) {
            return back()->with('error', 'Lo sentimos, el cupo para este evento está lleno.');
        }

        // 3. Generar un código único de confirmación (ej. EM-7K3F9)
        $code = $this->generateUniqueCode();

        // 4. Inscribirlo guardando el código en la tabla pivote
        $event->participants()->attach($user->id, [
            'confirmation_code' => $code,
        ]);

        // 5. Intentar enviar el ticket por correo (si el email está configurado).
        //    Si no lo está, NO rompe el registro: solo se registra en el log.
        try {
            Mail::to($user->email)->send(new EventTicketMail($event, $user, $code));
        } catch (\Throwable $e) {
            Log::warning('No se pudo enviar el correo del ticket: ' . $e->getMessage());
        }

        // 6. Llevar al ticket virtual imprimible
        return redirect()
            ->route('events.ticket', ['event' => $event->id, 'code' => $code])
            ->with('success', '¡Felicidades! Tu lugar ha sido reservado. Tu código es ' . $code);
    }

    // Ticket virtual imprimible (muestra el código para el día del evento)
    public function ticket($eventId, $code)
    {
        $event = Event::findOrFail($eventId);
        $user = Auth::user();

        // Verificamos que el código pertenezca a ESTE usuario y ESTE evento
        $registro = $event->participants()
            ->where('users.id', $user->id)
            ->wherePivot('confirmation_code', $code)
            ->first();

        if (!$registro) {
            return redirect()->route('dashboard')->with('error', 'No encontramos ese boleto.');
        }

        return view('events.ticket', [
            'event' => $event,
            'user' => $user,
            'code' => $code,
        ]);
    }

    // Genera un código único tipo EM-7K3F9 (sin letras/números confusos)
    private function generateUniqueCode(): string
    {
        // Alfabeto sin caracteres confusos (sin 0, O, 1, I)
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
