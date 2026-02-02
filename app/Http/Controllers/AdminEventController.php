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
            'start_date' => 'required|date',
            'location' => 'required',
            'capacity' => 'required|integer',
            'image_url' => 'nullable|url'
        ]);

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
            'image_url' => 'nullable|url'
        ]);

        // 2. Buscar y Actualizar
        $event = Event::findOrFail($id);
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
}