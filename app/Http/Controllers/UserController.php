<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function update(Request $request)
    {
        // Realiza la validación de los campos
        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string', 'min:2', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|net|org|edu|gov)$/i'],

            'name.min' => 'El nombre debe tener mínimo :min letras.',
            'name.regex' => 'El nombre no puede contener números ni caracteres especiales.',
            'email.email' => 'El email debe ser una dirección de correo válida.',
            'email.ends_with' => 'El email debe terminar en ".com, .net, .org, .edu, .gov".',

        ]);

        // Si la validación falla, redireccionar con los errores
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        if ($user) {
            // Verificar si el usuario ha actualizado algún campo
            if ($request->filled('name') || $request->filled('email') || $request->filled('gender')) {
                
                try {
                    $user = User::find($request->id);
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->gender = $request->gender;

                    $user->save();
                    return redirect('/')->with('success', 'Usuario actualizado exitosamente');
                } catch (QueryException $exception) {
                    //Si introduce email  existente le salta el mensaje de error
                    if ($exception->errorInfo[1] === 1062) {

                        throw ValidationException::withMessages(['email' => 'El correo electrónico  ya está en uso']);
                    } else {
                        // Manejar otros errores de la base de datos
                        // Por ejemplo, podrías registrar el error o redirigir a una página de error general
                        return redirect()->route('error')->with('error', 'Error en la base de datos');
                    }
                }
            } else {
                // Si el usuario no ha realizado cambios, redirigir a la página principal
                return redirect('/')->with('info', 'No se han realizado cambios');
            }
        } else {
            return redirect()->route('login')->with('success', '');
        }
    }

    public function edit()
    {
        $user = Auth::user();


        return view("user/userEditData", compact("user"));
    }

    public function seeData()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Cargar todas las playlists asociadas al usuario
        $playlists = $user->playlists;

        // Devolver la vista con el usuario y sus playlists
        return view("user/userData", compact('user', 'playlists'));
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(404, 'Usuario no encontrado');
        }

        return view('user.show', compact('user'));
    }
}
