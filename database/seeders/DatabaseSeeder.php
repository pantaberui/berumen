<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        $admin  = Role::create(['name' => 'admin']);
        $cajero = Role::create(['name' => 'cajero']);

        // Crear permisos básicos
        $permisos = [
            'clientes.ver', 'clientes.crear', 'clientes.editar', 'clientes.eliminar',
            'contratos.ver', 'contratos.crear',
            'pagos.ver', 'pagos.crear',
            'incidencias.ver', 'incidencias.crear',
            'reportes.ver',
            'usuarios.ver', 'usuarios.crear',
        ];

        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }

        // Admin tiene todos los permisos
        $admin->syncPermissions($permisos);

        // Cajero tiene permisos limitados
        $cajero->syncPermissions([
            'clientes.ver', 'clientes.crear',
            'contratos.ver', 'contratos.crear',
            'pagos.ver', 'pagos.crear',
            'incidencias.ver', 'incidencias.crear',
        ]);

        // Crear usuario administrador
        $adminUser = User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@berumen.com',
            'password' => Hash::make('berumen2024'),
        ]);
        $adminUser->assignRole('admin');

        // Crear usuario cajero de prueba
        $cajeroUser = User::create([
            'name'     => 'Cajero Demo',
            'email'    => 'cajero@berumen.com',
            'password' => Hash::make('cajero2024'),
        ]);
        $cajeroUser->assignRole('cajero');
    }
}