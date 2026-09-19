<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminEventController; // Para el panel de Liz
use App\Http\Controllers\EventController; // <--- ¡NUEVO! Para que funcione el registro
use App\Http\Controllers\ContactController; // Para la pestaña de Contacto
use App\Http\Controllers\ProgramController; // Página pública de detalle de cada programa
use App\Http\Controllers\AdminProgramController; // Panel de Liz para editar los programas
use App\Http\Controllers\AdminPeopleController; // Control de personas registradas
use App\Http\Controllers\HeroImageController; // Carrusel de fotos del inicio
use App\Http\Controllers\PaymentController; // Pagos con Mercado Pago (eventos y programas)
use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Models\Program;
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
    $programs = Program::orderBy('order')->orderBy('title')->get();
    $heroImages = \App\Models\HeroImage::where('active', true)->orderBy('order')->orderBy('id')->get();
    return view('welcome', compact('events', 'programs', 'heroImages'));
});

// Detalle del Evento
Route::get('/event/{id}', function ($id) {
    $event = Event::findOrFail($id);
    return view('events.show', compact('event'));
})->name('event.detail');

// Detalle público de un Programa (Wellness Day, Empowerme 30, Team Experience...)
Route::get('/programas/{slug}', [ProgramController::class, 'show'])->name('programs.show');

// Formulario de Contacto (pestaña CONTACTO)
Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store');

// Webhook de Mercado Pago (notificación automática de pagos).
// Público (MP no tiene login) y debe estar exento de CSRF (ver bootstrap/app.php).
Route::post('/webhook/mercadopago', [PaymentController::class, 'webhook'])->name('payment.webhook');
Route::get('/webhook/mercadopago', [PaymentController::class, 'webhook']); // MP a veces valida por GET


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

    // Ticket virtual imprimible con el código de confirmación
    Route::get('/event/{event}/ticket/{code}', [EventController::class, 'ticket'])->name('events.ticket');

    // --- PAGOS CON MERCADO PAGO ---
    // Eventos
    Route::get('/payment/event/{event}', [PaymentController::class, 'createEventPayment'])->name('payment.event.create');
    Route::get('/payment/event/{event}/success', [PaymentController::class, 'eventPaymentSuccess'])->name('payment.event.success');
    Route::get('/payment/event/{event}/failure', [PaymentController::class, 'eventPaymentFailure'])->name('payment.event.failure');
    Route::get('/payment/event/{event}/pending', [PaymentController::class, 'eventPaymentPending'])->name('payment.event.pending');

    // Confirmación manual (para localhost, cuando Mercado Pago no regresa solo)
    Route::get('/confirmar-inscripcion', [PaymentController::class, 'confirmarInscripcion'])->name('payment.confirm');
    Route::post('/confirmar-inscripcion', [PaymentController::class, 'confirmarInscripcionPost'])->name('payment.confirm.post');

    // Programas
    Route::get('/payment/program/{program}', [PaymentController::class, 'createProgramPayment'])->name('payment.program.create');
    Route::get('/payment/program/{program}/success', [PaymentController::class, 'programPaymentSuccess'])->name('payment.program.success');
    Route::get('/payment/program/{program}/failure', [PaymentController::class, 'programPaymentFailure'])->name('payment.program.failure');
    Route::get('/payment/program/{program}/pending', [PaymentController::class, 'programPaymentPending'])->name('payment.program.pending');
});


// --- 3. RUTAS DE ADMINISTRACIÓN DE PROGRAMAS (Panel de Liz) ---
// OJO: esto va ANTES del grupo "admin" de eventos, porque ese grupo tiene una ruta
// comodín /admin/{id} que si no, "atraparía" primero /admin/programas.
Route::middleware(['auth'])->prefix('admin/programas')->name('admin.programs.')->group(function () {

    Route::get('/', [AdminProgramController::class, 'index'])->name('index');
    Route::get('/create', [AdminProgramController::class, 'create'])->name('create');
    Route::post('/', [AdminProgramController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [AdminProgramController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AdminProgramController::class, 'update'])->name('update');
    Route::delete('/{id}', [AdminProgramController::class, 'destroy'])->name('destroy');
});

// --- 4. RUTAS DE ADMINISTRACIÓN DE EVENTOS (Panel de Liz) ---
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Personas registradas (control de asistencia global) — van ANTES del comodín /admin/{id}
    Route::get('/personas', [AdminPeopleController::class, 'index'])->name('people.index');
    Route::get('/personas/{id}', [AdminPeopleController::class, 'show'])->name('people.show');

    // Carrusel de fotos del inicio
    Route::get('/carrusel', [HeroImageController::class, 'index'])->name('hero.index');
    Route::post('/carrusel', [HeroImageController::class, 'store'])->name('hero.store');
    Route::post('/carrusel/{id}/toggle', [HeroImageController::class, 'toggle'])->name('hero.toggle');
    Route::delete('/carrusel/{id}', [HeroImageController::class, 'destroy'])->name('hero.destroy');

    // Panel principal
    Route::get('/', [AdminEventController::class, 'index'])->name('index');
    
    // Crear
    Route::get('/create', [AdminEventController::class, 'create'])->name('create');
    Route::post('/', [AdminEventController::class, 'store'])->name('store');
    
    // Ver inscritos
    Route::get('/{id}', [AdminEventController::class, 'show'])->name('show');

    // Check-in de asistencia
    Route::post('/{event}/checkin', [AdminEventController::class, 'checkinByCode'])->name('checkin');
    Route::post('/{event}/asistencia/{user}', [AdminEventController::class, 'toggleAttendance'])->name('attendance.toggle');
    
    // Editar
    Route::get('/{id}/edit', [AdminEventController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AdminEventController::class, 'update'])->name('update');
    
    // Eliminar
    Route::delete('/{id}', [AdminEventController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';