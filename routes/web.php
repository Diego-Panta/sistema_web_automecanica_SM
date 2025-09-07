<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoLeadController;
use App\Http\Controllers\EstadoLeadController;
use App\Http\Controllers\EstadoClienteController;
use App\Http\Controllers\EstadoUserController;
use App\Http\Controllers\CanaleController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\MedioContactoController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FormaRegistroController;
use App\Http\Controllers\ResultadoLeadController;
use App\Http\Controllers\AccioneController;
use App\Http\Controllers\MarcaVehiculoController;
use App\Http\Controllers\TipoVehiculoController;
use App\Http\Controllers\ModeloVehiculoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CiudadeController;
use App\Http\Controllers\AsignacionLeadController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('leads/status', function () {
    return view('leads/configuracion/estados/index');
});

// Rutas para la configuración de leads
Route::prefix('leads')->group(function () {

    // Asignaciones - DEBEN IR ANTES de las rutas con parámetros dinámicos
    Route::get('/assign', [AsignacionLeadController::class, 'index'])->name('leads.assign');
    Route::get('/assign/create', [AsignacionLeadController::class, 'create'])->name('leads.assign.create');
    Route::post('/assign', [AsignacionLeadController::class, 'store'])->name('leads.assign.store');
    Route::get('/assign/{lead}/edit', [AsignacionLeadController::class, 'edit'])->name('leads.assign.edit');
    Route::put('/assign/{lead}', [AsignacionLeadController::class, 'update'])->name('leads.assign.update');
    Route::delete('/assign/{assignment}', [AsignacionLeadController::class, 'destroy'])->name('leads.assign.destroy');
    Route::get('/assign/history', [AsignacionLeadController::class, 'history'])->name('leads.assign.history');

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

    // Medios de contactos
    Route::get('/contacts', [MedioContactoController::class, 'index'])->name('leads.contacts');
    Route::get('/contacts/create', [MedioContactoController::class, 'create'])->name('leads.contacts.create');
    Route::post('/contacts', [MedioContactoController::class, 'store'])->name('leads.contacts.store');
    Route::get('/contacts/{contacto}/edit', [MedioContactoController::class, 'edit'])->name('leads.contacts.edit');
    Route::put('/contacts/{contacto}', [MedioContactoController::class, 'update'])->name('leads.contacts.update');
    Route::delete('/contacts/{contacto}', [MedioContactoController::class, 'destroy'])->name('leads.contacts.destroy');

    // Formas de registro
    Route::get('/registrations', [FormaRegistroController::class, 'index'])->name('leads.registrations');
    Route::get('/registrations/create', [FormaRegistroController::class, 'create'])->name('leads.registrations.create');
    Route::post('/registrations', [FormaRegistroController::class, 'store'])->name('leads.registrations.store');
    Route::get('/registrations/{registro}/edit', [FormaRegistroController::class, 'edit'])->name('leads.registrations.edit');
    Route::put('/registrations/{registro}', [FormaRegistroController::class, 'update'])->name('leads.registrations.update');
    Route::delete('/registrations/{registro}', [FormaRegistroController::class, 'destroy'])->name('leads.registrations.destroy');

    // Tipos de resultados
    Route::get('/results', [ResultadoLeadController::class, 'index'])->name('leads.results');
    Route::get('/results/create', [ResultadoLeadController::class, 'create'])->name('leads.results.create');
    Route::post('/results', [ResultadoLeadController::class, 'store'])->name('leads.results.store');
    Route::get('/results/{resultado}/edit', [ResultadoLeadController::class, 'edit'])->name('leads.results.edit');
    Route::put('/results/{resultado}', [ResultadoLeadController::class, 'update'])->name('leads.results.update');
    Route::delete('/results/{resultado}', [ResultadoLeadController::class, 'destroy'])->name('leads.results.destroy');

    // Estados
    Route::get('/status', [EstadoLeadController::class, 'index'])->name('leads.status');
    Route::get('/status/create', [EstadoLeadController::class, 'create'])->name('leads.status.create');
    Route::post('/status', [EstadoLeadController::class, 'store'])->name('leads.status.store');
    Route::get('/status/{estado}/edit', [EstadoLeadController::class, 'edit'])->name('leads.status.edit');
    Route::put('/status/{estado}', [EstadoLeadController::class, 'update'])->name('leads.status.update');
    Route::delete('/status/{estado}', [EstadoLeadController::class, 'destroy'])->name('leads.status.destroy');
    
    // Rutas adicionales - DEBEN IR ANTES de las rutas con parámetros dinámicos
    Route::get('/import', [LeadController::class, 'import'])->name('leads.import');
    Route::post('/import', [LeadController::class, 'processImport'])->name('leads.process.import');
    
    // Manejar marca
    Route::get('/modelos-por-marca/{marcaId}', [LeadController::class, 'getModelosPorMarca'])->name('leads.modelos.por.marca');
    
    // Rutas principales de leads
    Route::get('/', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/create', [LeadController::class, 'create'])->name('leads.create');
    Route::post('/', [LeadController::class, 'store'])->name('leads.store');
    Route::get('/create/manual', [LeadController::class, 'createManual'])->name('leads.create.manual');
    Route::post('/create/manual', [LeadController::class, 'storeManual'])->name('leads.store.manual');
    
    // Rutas con parámetros dinámicos - DEBEN IR AL FINAL
    Route::get('/{lead}', [LeadController::class, 'show'])->name('leads.show');
    Route::get('/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit');
    Route::put('/{lead}', [LeadController::class, 'update'])->name('leads.update');
    Route::delete('/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
    
});


Route::prefix('clientes')->name('clientes.')->group(function () {
    Route::get('/', [ClienteController::class, 'index'])->name('index');
    Route::get('/crear', [ClienteController::class, 'create'])->name('create');
    
    // Estados - MOVER ANTES de las rutas con parámetros dinámicos
    Route::get('/status', [EstadoClienteController::class, 'index'])->name('status');
    Route::get('/status/create', [EstadoClienteController::class, 'create'])->name('status.create');
    Route::post('/status', [EstadoClienteController::class, 'store'])->name('status.store');
    Route::get('/status/{estado}/edit', [EstadoClienteController::class, 'edit'])->name('status.edit');
    Route::put('/status/{estado}', [EstadoClienteController::class, 'update'])->name('status.update');
    Route::delete('/status/{estado}', [EstadoClienteController::class, 'destroy'])->name('status.destroy');
    
    // Rutas de clientes con parámetros dinámicos - DESPUÉS
    Route::post('/', [ClienteController::class, 'store'])->name('store');
    Route::get('/{cliente}', [ClienteController::class, 'show'])->name('show');
    Route::get('/{cliente}/editar', [ClienteController::class, 'edit'])->name('edit');
    Route::put('/{cliente}', [ClienteController::class, 'update'])->name('update');
    Route::delete('/{cliente}', [ClienteController::class, 'destroy'])->name('destroy');
});

Route::prefix('users')->group(function () {

    // Rutas para Listado de Usuarios
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Rutas para Roles
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('users.roles');
        Route::get('/create', [RoleController::class, 'create'])->name('users.roles.create');
        Route::post('/', [RoleController::class, 'store'])->name('users.roles.store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('users.roles.edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('users.roles.update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('users.roles.destroy');
    });

    // Rutas para Permisos
    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('users.permissions');
        Route::get('/create', [PermissionController::class, 'create'])->name('users.permissions.create');
        Route::post('/', [PermissionController::class, 'store'])->name('users.permissions.store');
        Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('users.permissions.edit');
        Route::put('/{permission}', [PermissionController::class, 'update'])->name('users.permissions.update');
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('users.permissions.destroy');
    });

    // Rutas para Asignación de Permisos a Roles
    Route::prefix('role-permissions')->group(function () {
        Route::get('/{role}', [RolePermissionController::class, 'edit'])->name('users.role-permissions.edit');
        Route::put('/{role}', [RolePermissionController::class, 'update'])->name('users.role-permissions.update');
    });

    // Estados
    Route::get('/status', [EstadoUserController::class, 'index'])->name('users.status');
    Route::get('/status/create', [EstadoUserController::class, 'create'])->name('users.status.create');
    Route::post('/status', [EstadoUserController::class, 'store'])->name('users.status.store');
    Route::get('/status/{estado}/edit', [EstadoUserController::class, 'edit'])->name('users.status.edit');
    Route::put('/status/{estado}', [EstadoUserController::class, 'update'])->name('users.status.update');
    Route::delete('/status/{estado}', [EstadoUserController::class, 'destroy'])->name('users.status.destroy');
});

Route::prefix('locations')->group(function () {

    Route::get('/ciudades', [CiudadeController::class, 'index'])->name('locations.ciudades');
    Route::get('/ciudades/create', [CiudadeController::class, 'create'])->name('locations.ciudades.create');
    Route::post('/ciudades', [CiudadeController::class, 'store'])->name('locations.ciudades.store');
    Route::get('/ciudades/{ciudad}/edit', [CiudadeController::class, 'edit'])->name('locations.ciudades.edit');
    Route::put('/ciudades/{ciudad}', [CiudadeController::class, 'update'])->name('locations.ciudades.update');
    Route::delete('/ciudades/{ciudad}', [CiudadeController::class, 'destroy'])->name('locations.ciudades.destroy');

    Route::get('/sedes', [SedeController::class, 'index'])->name('locations.sedes');
    Route::get('/sedes/create', [SedeController::class, 'create'])->name('locations.sedes.create');
    Route::post('/sedes', [SedeController::class, 'store'])->name('locations.sedes.store');
    Route::get('/sedes/{sede}/edit', [SedeController::class, 'edit'])->name('locations.sedes.edit');
    Route::put('/sedes/{sede}', [SedeController::class, 'update'])->name('locations.sedes.update');
    Route::delete('/sedes/{sede}', [SedeController::class, 'destroy'])->name('locations.sedes.destroy');

    Route::get('/turnos', [TurnoController::class, 'index'])->name('locations.turnos');
    Route::get('/turnos/create', [TurnoController::class, 'create'])->name('locations.turnos.create');
    Route::post('/turnos', [TurnoController::class, 'store'])->name('locations.turnos.store');
    Route::get('/turnos/{turno}/edit', [TurnoController::class, 'edit'])->name('locations.turnos.edit');
    Route::put('/turnos/{turno}', [TurnoController::class, 'update'])->name('locations.turnos.update');
    Route::delete('/turnos/{turno}', [TurnoController::class, 'destroy'])->name('locations.turnos.destroy');
});

//Aciones
Route::prefix('accions')->group(function () {
    Route::get('/', [AccioneController::class, 'index'])->name('accions.index');
    Route::get('/create', [AccioneController::class, 'create'])->name('accions.create');
    Route::post('/', [AccioneController::class, 'store'])->name('accions.store');
    Route::get('/{accion}/edit', [AccioneController::class, 'edit'])->name('accions.edit');
    Route::put('/{accion}', [AccioneController::class, 'update'])->name('accions.update');
    Route::delete('/{accion}', [AccioneController::class, 'destroy'])->name('accions.destroy');
});

Route::prefix('vehicles')->group(function () {

    // Rutas para Modelos
    Route::get('/models', [ModeloVehiculoController::class, 'index'])->name('vehicles.models');
    Route::get('/models/create', [ModeloVehiculoController::class, 'create'])->name('vehicles.models.create');
    Route::post('/models', [ModeloVehiculoController::class, 'store'])->name('vehicles.models.store');
    Route::get('/models/{model}/edit', [ModeloVehiculoController::class, 'edit'])->name('vehicles.models.edit');
    Route::put('/models/{model}', [ModeloVehiculoController::class, 'update'])->name('vehicles.models.update');
    Route::delete('/models/{model}', [ModeloVehiculoController::class, 'destroy'])->name('vehicles.models.destroy');

    // Rutas para Marcas
    Route::get('/brands', [MarcaVehiculoController::class, 'index'])->name('vehicles.brands');
    Route::get('/brands/create', [MarcaVehiculoController::class, 'create'])->name('vehicles.brands.create');
    Route::post('/brands', [MarcaVehiculoController::class, 'store'])->name('vehicles.brands.store');
    Route::get('/brands/{brand}/edit', [MarcaVehiculoController::class, 'edit'])->name('vehicles.brands.edit');
    Route::put('/brands/{brand}', [MarcaVehiculoController::class, 'update'])->name('vehicles.brands.update');
    Route::delete('/brands/{brand}', [MarcaVehiculoController::class, 'destroy'])->name('vehicles.brands.destroy');

    // Rutas para Tipos
    Route::get('/types', [TipoVehiculoController::class, 'index'])->name('vehicles.types');
    Route::get('/types/create', [TipoVehiculoController::class, 'create'])->name('vehicles.types.create');
    Route::post('/types', [TipoVehiculoController::class, 'store'])->name('vehicles.types.store');
    Route::get('/types/{type}/edit', [TipoVehiculoController::class, 'edit'])->name('vehicles.types.edit');
    Route::put('/types/{type}', [TipoVehiculoController::class, 'update'])->name('vehicles.types.update');
    Route::delete('/types/{type}', [TipoVehiculoController::class, 'destroy'])->name('vehicles.types.destroy');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
