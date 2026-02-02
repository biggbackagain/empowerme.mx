<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Función para registrar al usuario en el evento
    public function register($id)
    {
        $event = Event::findOrFail($id);
        $user = Auth::user();

        // 1. Validar si ya está inscrito
        if ($event->participants->contains($user->id)) {
            return back()->with('error', 'Ya te habías inscrito anteriormente a este evento.');
        }

        // 2. Validar si hay cupo
        if ($event->participants()->count() >= $event->capacity) {
            return back()->with('error', 'Lo sentimos, el cupo para este evento está lleno.');
        }

        // 3. ¡Inscribirlo! (Guardar en tabla pivote event_user)
        $event->participants()->attach($user->id);

        // 4. Regresar con mensaje de éxito
        return back()->with('success', '¡Felicidades! Tu lugar ha sido reservado.');
    }
}