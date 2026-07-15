<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $cajero = Role::firstOrCreate([
            'name' => 'cajero',
            'guard_name' => 'web',
        ]);

        $permisos = [
            'clientes.ver',
            'clientes.crear',
            'clientes.editar',
            'clientes.eliminar',

            'contratos.ver',
            'contratos.crear',

            'pagos.ver',
            'pagos.crear',

            'incidencias.ver',
            'incidencias.crear',

            'reportes.ver',

            'usuarios.ver',
            'usuarios.crear',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => 'web',
            ]);
        }

        $admin->syncPermissions($permisos);

        $cajero->syncPermissions([
            'clientes.ver',
            'clientes.crear',
            'contratos.ver',
            'contratos.crear',
            'pagos.ver',
            'pagos.crear',
            'incidencias.ver',
            'incidencias.crear',
        ]);

        $adminUser = User::updateOrCreate(
            [
                'email' => 'admin@berumen.com',
            ],
            [
                'name' => 'Administrador',
                'password' => Hash::make('berumen2024'),
            ]
        );

        $adminUser->syncRoles([$admin]);

        $cajeroUser = User::updateOrCreate(
            [
                'email' => 'cajero@berumen.com',
            ],
            [
                'name' => 'Cajero Demo',
                'password' => Hash::make('cajero2024'),
            ]
        );

        $cajeroUser->syncRoles([$cajero]);
    }
}
