<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Usuario::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:Usuario',
            'email' => 'required|string|email|max:255|unique:Usuario',
            'password' => 'required|string|min:8',
        ]);

        $usuario = Usuario::create([
            'name' => $validatedData['name'],
            'cpf' => $validatedData['cpf'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return response()->json($usuario, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        return response()->json($usuario);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario = Usuario::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'cpf' => 'sometimes|required|string|max:14|unique:Usuario,cpf,' . $id,
            'email' => 'sometimes|required|string|email|max:255|unique:Usuario,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $usuario->update($validatedData);

        return response()->json($usuario);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return response()->json(null, 204);
    }
}
