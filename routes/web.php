<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminEventController; // Para el panel de Liz
use App\Http\Controllers\EventController; // <--- ¡NUEVO! Para que funcione el registro
use Illuminate\Support\Facades\Route;
use App\Models\Event;
use Illuminate\Support\Facades\Auth; // Necesario para el dashboard híbrido

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. RUTAS PÚBLICAS ---

// Página de Inicio
Route::get('/', function () {
    $events = Event::orderBy('start_date', 'asc')->get(); 
    return view('welcome', compact('events'));
});

// Detalle del Evento
Route::get('/event/{id}', function ($id) {
    $event = Event::findOrFail($id);
    return view('events.show', compact('event'));
})->name('event.detail');


// --- 2. RUTAS DE USUARIO (Dashboard y Perfil) ---

// Dashboard Híbrido
Route::get('/dashboard', function () {
    // 1. Obtenemos los eventos para que el Admin los vea
    $allEvents = \App\Models\Event::withCount('participants')->orderBy('start_date', 'desc')->get();
    
    // 2. Obtenemos los eventos donde ESTE usuario se inscribió
    $myEvents = Auth::user()->events;

    return view('dashboard', compact('allEvents', 'myEvents'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- AQUÍ ESTÁ LA NUEVA RUTA DE REGISTRO ---
    // Esta línea conecta el botón "Quiero Inscribirme" con el Controlador
    Route::post('/event/{id}/register', [EventController::class, 'register'])->name('events.register');
});


// --- 3. RUTAS DE ADMINISTRACIÓN (Panel de Liz) ---
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Panel principal
    Route::get('/', [AdminEventController::class, 'index'])->name('index');
    
    // Crear
    Route::get('/create', [AdminEventController::class, 'create'])->name('create');
    Route::post('/', [AdminEventController::class, 'store'])->name('store');
    
    // Ver inscritos
    Route::get('/{id}', [AdminEventController::class, 'show'])->name('show');
    
    // Editar
    Route::get('/{id}/edit', [AdminEventController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AdminEventController::class, 'update'])->name('update');
    
    // Eliminar
    Route::delete('/{id}', [AdminEventController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';