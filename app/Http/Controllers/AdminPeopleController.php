<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminPeopleController extends Controller
{
    // Lista de personas registradas con a cuántos eventos han ido
    public function index(Request $request)
    {
        $buscar = trim((string) $request->get('q', ''));

        $people = User::query()
            ->withCount('events')
            ->when($buscar !== '', function ($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%");
            })
            ->orderByDesc('events_count')
            ->orderBy('name')
            ->get();

        return view('admin.people.index', compact('people', 'buscar'));
    }

    // Detalle de una persona: a cuáles eventos ha ido
    public function show($id)
    {
        $person = User::with(['events' => function ($q) {
            $q->orderBy('start_date', 'desc');
        }])->findOrFail($id);

        return view('admin.people.show', compact('person'));
    }
}
