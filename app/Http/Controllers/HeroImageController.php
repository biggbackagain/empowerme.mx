<?php

namespace App\Http\Controllers;

use App\Models\HeroImage;
use Illuminate\Http\Request;

class HeroImageController extends Controller
{
    public function index()
    {
        $images = HeroImage::orderBy('order')->orderBy('id')->get();
        return view('admin.hero.index', compact('images'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image_url' => 'nullable|string|max:2048',
            'image_file' => 'nullable|image|max:6144', // hasta 6MB
            'caption' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('hero', 'public');
            $data['image_url'] = '/storage/' . $path;
        }
        unset($data['image_file']);

        if (empty($data['image_url'])) {
            return back()->with('error', 'Debes subir una foto o pegar una URL.');
        }

        $data['order'] = $data['order'] ?? 0;
        $data['active'] = true;

        HeroImage::create($data);

        return back()->with('success', 'Foto agregada al carrusel.');
    }

    public function toggle($id)
    {
        $image = HeroImage::findOrFail($id);
        $image->update(['active' => !$image->active]);
        return back()->with('success', $image->active ? 'Foto activada.' : 'Foto ocultada del carrusel.');
    }

    public function destroy($id)
    {
        $image = HeroImage::findOrFail($id);
        $image->delete();
        return back()->with('success', 'Foto eliminada del carrusel.');
    }
}
