<?php

namespace App\Http\Controllers;

use App\Models\Program;

class ProgramController extends Controller
{
    // Página pública de detalle de un programa (Wellness Day, Empowerme 30, etc.)
    public function show($slug)
    {
        $program = Program::where('slug', $slug)->firstOrFail();
        return view('programs.show', compact('program'));
    }
}
