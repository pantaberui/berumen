<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('roles')->orderBy('name')->paginate(15);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'celular'          => 'nullable|string|max:15',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|string|min:8|confirmed',
            'role'             => 'required|exists:roles,name',
        ], [
            'email.unique'       => 'Ya existe un usuario con ese correo.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $usuario = User::create([
            'name'             => strtoupper($request->name),
            'apellido_paterno' => strtoupper($request->apellido_paterno),
            'celular'          => $request->celular,
            'email'            => $request->email,
            'password'         => Hash::make($request->password),
        ]);

        $usuario->assignRole($request->role);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario)
    {
        $roles = Role::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name'             => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'celular'          => 'nullable|string|max:15',
            'email'            => 'required|email|unique:users,email,' . $usuario->id,
            'password'         => 'nullable|string|min:8|confirmed',
            'role'             => 'required|exists:roles,name',
        ]);

        $data = [
            'name'             => strtoupper($request->name),
            'apellido_paterno' => strtoupper($request->apellido_paterno),
            'celular'          => $request->celular,
            'email'            => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);
        $usuario->syncRoles([$request->role]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }
        $usuario->delete();
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
