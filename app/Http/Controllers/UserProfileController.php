<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(Request $request)
    {
        // Obtener el usuario autenticado usando el token
        $user = $request->user();

        // Retornar solo los datos que te interesan
        return response()->json([
            'apellido_paterno' => $user->apellido_paterno,
            'apellido_materno' => $user->apellido_materno,
            'nombres' => $user->nombres,
            'tipo_doc' => $user->tipo_doc,
            'num_doc' => $user->num_doc,
            'celular' => $user->celular,
            'email' => $user->email,
        ]);
    }
}
