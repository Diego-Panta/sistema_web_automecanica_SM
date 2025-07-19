<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoLeadController;
use App\Http\Controllers\EstadoLeadController;
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
    /*Route::get('/channels', [LeadConfigController::class, 'channelsIndex'])->name('leads.channels');
    Route::get('/channels/create', [LeadConfigController::class, 'channelsCreate'])->name('leads.channels.create');
    Route::post('/channels', [LeadConfigController::class, 'channelsStore'])->name('leads.channels.store');
    Route::get('/channels/{canal}/edit', [LeadConfigController::class, 'channelsEdit'])->name('leads.channels.edit');
    Route::put('/channels/{canal}', [LeadConfigController::class, 'channelsUpdate'])->name('leads.channels.update');
    Route::delete('/channels/{canal}', [LeadConfigController::class, 'channelsDestroy'])->name('leads.channels.destroy');*/
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
