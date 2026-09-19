<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProgramController extends Controller
{
    // 1. Panel principal (lista de programas)
    public function index()
    {
        $programs = Program::orderBy('order')->orderBy('title')->get();
        return view('admin.programs.index', compact('programs'));
    }

    // 2. Formulario de crear
    public function create()
    {
        return view('admin.programs.create');
    }

    // 3. Guardar nuevo programa
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'includes' => 'nullable|string',
            'price' => 'nullable|string|max:255',
            'numeric_price' => 'nullable|numeric|min:0',
            'image_url' => 'nullable|string|max:2048',
            'image_file' => 'nullable|image|max:4096',
            'image_position' => 'nullable|in:top,center,bottom',
            'order' => 'nullable|integer',
        ]);

        // Si suben un archivo desde la computadora, tiene prioridad sobre la URL
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('programas', 'public');
            $data['image_url'] = '/storage/' . $path;
        }
        unset($data['image_file']);

        $data['image_position'] = $data['image_position'] ?? 'center';
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['order'] = $data['order'] ?? 0;

        Program::create($data);

        return redirect()->route('admin.programs.index')->with('success', 'Programa creado correctamente.');
    }

    // 4. Formulario de editar
    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('admin.programs.edit', compact('program'));
    }

    // 5. Actualizar cambios
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'includes' => 'nullable|string',
            'price' => 'nullable|string|max:255',
            'numeric_price' => 'nullable|numeric|min:0',
            'image_url' => 'nullable|string|max:2048',
            'image_file' => 'nullable|image|max:4096',
            'image_position' => 'nullable|in:top,center,bottom',
            'order' => 'nullable|integer',
        ]);

        $program = Program::findOrFail($id);

        // Si suben un archivo desde la computadora, tiene prioridad sobre la URL
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('programas', 'public');
            $data['image_url'] = '/storage/' . $path;
        }
        unset($data['image_file']);

        $data['image_position'] = $data['image_position'] ?? 'center';

        // Si cambia el título, regeneramos el slug (evitando choques con otros programas)
        if ($data['title'] !== $program->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $program->id);
        }

        $data['order'] = $data['order'] ?? 0;

        $program->update($data);

        return redirect()->route('admin.programs.index')->with('success', '¡Programa actualizado correctamente!');
    }

    // 6. Eliminar
    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Programa eliminado.');
    }

    // Genera un slug único a partir del título (para la URL pública /programas/{slug})
    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (
            Program::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
