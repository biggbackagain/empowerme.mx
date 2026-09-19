<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    // Recibe el formulario de la pestaña "Contacto"
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'name.required'    => 'Por favor comparte tu nombre completo.',
            'email.required'   => 'Por favor comparte un correo de contacto.',
            'email.email'      => 'El correo no parece válido.',
            'message.required' => 'Cuéntanos cómo podemos ayudarte.',
        ]);

        // TODO: cuando tengan un correo/CRM definitivo, aquí se puede
        // reemplazar por Mail::to(...)->send(...) o guardar en una tabla.
        // Por ahora se registra en el log para no perder ningún mensaje.
        Log::info('Nuevo mensaje de contacto EmpowerMe', $validated);

        return back()->with('contact_success', '¡Gracias! Recibimos tu mensaje y te contactaremos pronto.');
    }
}
