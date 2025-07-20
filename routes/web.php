<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoLeadController;
use App\Http\Controllers\EstadoLeadController;
use App\Http\Controllers\EstadoClienteController;
use App\Http\Controllers\EstadoUserController;
use App\Http\Controllers\CanaleController;
use App\Http\Controllers\SedeController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('leads/status', function () {
    return view('leads/configuracion/estados/index');
});

// Rutas para la configuración de leads
Route::prefix('leads')->group(function () {
    // Estados
    Route::get('/status', [EstadoLeadController::class, 'index'])->name('leads.status');
    Route::get('/status/create', [EstadoLeadController::class, 'create'])->name('leads.status.create');
    Route::post('/status', [EstadoLeadController::class, 'store'])->name('leads.status.store');
    Route::get('/status/{estado}/edit', [EstadoLeadController::class, 'edit'])->name('leads.status.edit');
    Route::put('/status/{estado}', [EstadoLeadController::class, 'update'])->name('leads.status.update');
    Route::delete('/status/{estado}', [EstadoLeadController::class, 'destroy'])->name('leads.status.destroy');
    
    // Tipos de Lead (actualizadas con CRUD completo)
    Route::get('/types', [TipoLeadController::class, 'index'])->name('leads.types.index');
    Route::get('/types/create', [TipoLeadController::class, 'create'])->name('leads.types.create');
    Route::post('/types', [TipoLeadController::class, 'store'])->name('leads.types.store');
    Route::get('/types/{tipo}/edit', [TipoLeadController::class, 'edit'])->name('leads.types.edit');
    Route::put('/types/{tipo}', [TipoLeadController::class, 'update'])->name('leads.types.update');
    Route::delete('/types/{tipo}', [TipoLeadController::class, 'destroy'])->name('leads.types.destroy');
    
    // Canales
    Route::get('/channels', [CanaleController::class, 'index'])->name('leads.channels');
    Route::get('/channels/create', [CanaleController::class, 'create'])->name('leads.channels.create');
    Route::post('/channels', [CanaleController::class, 'store'])->name('leads.channels.store');
    Route::get('/channels/{canal}/edit', [CanaleController::class, 'edit'])->name('leads.channels.edit');
    Route::put('/channels/{canal}', [CanaleController::class, 'update'])->name('leads.channels.update');
    Route::delete('/channels/{canal}', [CanaleController::class, 'destroy'])->name('leads.channels.destroy');
});

Route::prefix('clients')->group(function () {
    // Estados
    Route::get('/status', [EstadoClienteController::class, 'index'])->name('clients.status');
    Route::get('/status/create', [EstadoClienteController::class, 'create'])->name('clients.status.create');
    Route::post('/status', [EstadoClienteController::class, 'store'])->name('clients.status.store');
    Route::get('/status/{estado}/edit', [EstadoClienteController::class, 'edit'])->name('clients.status.edit');
    Route::put('/status/{estado}', [EstadoClienteController::class, 'update'])->name('clients.status.update');
    Route::delete('/status/{estado}', [EstadoClienteController::class, 'destroy'])->name('clients.status.destroy');

});

Route::prefix('users')->group(function () {
    // Estados
    Route::get('/status', [EstadoUserController::class, 'index'])->name('users.status');
    Route::get('/status/create', [EstadoUserController::class, 'create'])->name('users.status.create');
    Route::post('/status', [EstadoUserController::class, 'store'])->name('users.status.store');
    Route::get('/status/{estado}/edit', [EstadoUserController::class, 'edit'])->name('users.status.edit');
    Route::put('/status/{estado}', [EstadoUserController::class, 'update'])->name('users.status.update');
    Route::delete('/status/{estado}', [EstadoUserController::class, 'destroy'])->name('users.status.destroy');

});

Route::prefix('locations')->group(function () {
    // Estados
    Route::get('/sedes', [SedeController::class, 'index'])->name('locations.sedes');
    Route::get('/sedes/create', [SedeController::class, 'create'])->name('locations.sedes.create');
    Route::post('/sedes', [SedeController::class, 'store'])->name('locations.sedes.store');
    Route::get('/sedes/{estado}/edit', [SedeController::class, 'edit'])->name('locations.sedes.edit');
    Route::put('/sedes/{estado}', [SedeController::class, 'update'])->name('locations.sedes.update');
    Route::delete('/sedes/{estado}', [SedeController::class, 'destroy'])->name('locations.sedes.destroy');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
