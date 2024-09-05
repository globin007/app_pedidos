<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Obtenemos las credenciales del request
        $credentials = $request->only('email', 'password');

        //  Autenticamos al usuario con las credenciales proporcionadas
        if (Auth::attempt($credentials)) {
            // Obtenemos el usuario autenticado
            $user = Auth::user();

            // Creamos un token de API para el usuario autenticado
            $token = $user->createToken('API Token')->plainTextToken;

            // Retornamos una respuesta JSON con el token y los datos del usuario, y el código de estado 200 (OK)
            return response()->json(['token' => $token, 'user' => $user], 200);
        }

        // Si las credenciales son inválidas, retornamos un mensaje de error con el código de estado 401 (Unauthorized)
        return response()->json(['message' => 'Credenciales Invalidas'], 401);
    }
}
