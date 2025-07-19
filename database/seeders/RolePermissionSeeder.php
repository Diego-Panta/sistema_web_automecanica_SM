<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permisos para Leads
        Permission::create(['name' => 'gestionar_leads']);
        Permission::create(['name' => 'asignar_leads']);
        Permission::create(['name' => 'ver_reportes_leads']);
        
        // Permisos para Clientes
        Permission::create(['name' => 'gestionar_clientes']);
        
        // Permisos para Vehículos
        Permission::create(['name' => 'gestionar_vehiculos']);
        
        // Permisos para Usuarios
        Permission::create(['name' => 'gestionar_usuarios']);

        // Crear roles y asignar permisos
        $roleMarketing = Role::create(['name' => 'marketing'])
            ->givePermissionTo(['gestionar_leads', 'asignar_leads', 'ver_reportes_leads']);

        $roleAsesorVentas = Role::create(['name' => 'asesor ventas'])
            ->givePermissionTo(['gestionar_leads', 'ver_reportes_leads']);

        $roleJefeRepuestos = Role::create(['name' => 'jefe repuestos'])
            ->givePermissionTo(['gestionar_vehiculos']);

        $roleJefePostventa = Role::create(['name' => 'jefe postventa'])
            ->givePermissionTo(['gestionar_clientes']);
    }
}
