<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'nombres' => 'required|string|max:255',
            'tipo_doc' => 'required|string|max:255',
            'num_doc' => 'required|string|max:255',
            'celular' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users_app',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'nombres' => $request->nombres,
            'tipo_doc' => $request->tipo_doc,
            'num_doc' => $request->num_doc,
            'celular' => $request->celular,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user], 200);
        }

        return response()->json(['message' => 'Credenciales Invalidas'], 401);
    }
}
