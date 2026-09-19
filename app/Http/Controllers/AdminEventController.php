<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class AdminEventController extends Controller
{
    // 1. Panel Principal (Lista de eventos)
    public function index()
    {
        $events = Event::orderBy('start_date', 'desc')->get();
        return view('admin.index', compact('events'));
    }

    // 2. Formulario de Crear
    public function create()
    {
        return view('admin.create');
    }

    // 3. Guardar nuevo evento
    public function store(Request $request)
    {
        // Validación simple
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'recommendations' => 'nullable|string',
            'start_date' => 'required|date',
            'location' => 'required',
            'capacity' => 'required|integer',
            'price' => 'nullable|numeric|min:0',
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|max:4096', // hasta 4MB
            'image_position' => 'nullable|in:top,center,bottom',
        ]);

        // Si suben un archivo desde la computadora, tiene prioridad sobre la URL
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('eventos', 'public');
            $data['image_url'] = '/storage/' . $path;
        }
        unset($data['image_file']);

        $data['image_position'] = $data['image_position'] ?? 'center';

        Event::create($data);
        return redirect()->route('admin.index')->with('success', 'Evento creado correctamente.');
    }

    // 4. Ver Inscritos (LO MÁS IMPORTANTE)
    public function show($id)
    {
        // Traemos el evento CON sus participantes (Eager Loading)
        $event = Event::with('participants')->findOrFail($id);
        return view('admin.show', compact('event'));
    }

    // 5. Formulario de Editar
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.edit', compact('event'));
    }

    // 6. Actualizar cambios
    public function update(Request $request, $id)
    {
        // 1. Validar los datos (Igual que al crear)
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'recommendations' => 'nullable|string',
            'start_date' => 'required|date',
            'location' => 'required',
            'capacity' => 'required|integer',
            'price' => 'nullable|numeric|min:0',
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|max:4096',
            'image_position' => 'nullable|in:top,center,bottom',
        ]);

        // 2. Buscar y Actualizar
        $event = Event::findOrFail($id);

        // Si suben un archivo desde la computadora, tiene prioridad sobre la URL
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('eventos', 'public');
            $data['image_url'] = '/storage/' . $path;
        }
        unset($data['image_file']);

        $data['image_position'] = $data['image_position'] ?? 'center';

        $event->update($data);

        // 3. Redirigir AL DASHBOARD (No a admin.index)
        return redirect()->route('dashboard')->with('success', '¡Evento actualizado correctamente!');
    }

    // 7. Eliminar
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('admin.index')->with('success', 'Evento eliminado.');
    }

    // 8. Marcar / desmarcar asistencia de una persona (casilla en la lista)
    public function toggleAttendance(Request $request, $eventId, $userId)
    {
        $event = Event::findOrFail($eventId);
        $registro = $event->participants()->where('users.id', $userId)->first();

        if (!$registro) {
            return back()->with('error', 'Esa persona no está inscrita en este evento.');
        }

        $yaAsistio = (bool) $registro->pivot->attended;

        $event->participants()->updateExistingPivot($userId, [
            'attended' => !$yaAsistio,
            'attended_at' => !$yaAsistio ? now() : null,
        ]);

        return back()->with('success', $yaAsistio
            ? 'Se quitó la asistencia de ' . $registro->name . '.'
            : '✅ Asistencia confirmada para ' . $registro->name . '.');
    }

    // 9. Check-in por código (pegar el código y confirmar al instante)
    public function checkinByCode(Request $request, $eventId)
    {
        $request->validate(['confirmation_code' => 'required|string']);

        $event = Event::with('participants')->findOrFail($eventId);
        $code = strtoupper(trim($request->confirmation_code));

        $persona = $event->participants()
            ->wherePivot('confirmation_code', $code)
            ->first();

        if (!$persona) {
            return back()->with('error', "El código \"{$code}\" no corresponde a nadie inscrito en este evento.");
        }

        if ($persona->pivot->attended) {
            return back()->with('error', "⚠️ El código {$code} es de {$persona->name}, pero ya había sido registrado como asistente.");
        }

        $event->participants()->updateExistingPivot($persona->id, [
            'attended' => true,
            'attended_at' => now(),
        ]);

        return back()->with('success', "✅ ¡Bienvenida/o {$persona->name}! Asistencia confirmada (código {$code}).");
    }
}