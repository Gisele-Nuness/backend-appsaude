<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'        => ['required', 'string', 'min:2'],
            'data_nasc'   => ['nullable', 'date'],
            'peso'        => ['nullable', 'numeric'],
            'altura'      => ['nullable', 'numeric'],
            'tipo_sangue' => ['nullable', 'string', 'max:5'],
            'cep'         => ['nullable', 'string', 'max:9'],
            'logradouro'  => ['nullable', 'string'],
            'numero'      => ['nullable', 'string'],
            'bairro'      => ['nullable', 'string'],
            'cidade'      => ['nullable', 'string'],
            'email'       => ['required', 'email', 'unique:users,email'],
            'senha'       => ['required', 'string', 'min:6'],
        ]);

        // hash da senha antes de salvar
        $data['senha'] = bcrypt($data['senha']);

        $user = User::create($data);

        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'senha' => ['required', 'string']
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return response()->json(['ok' => false, 'message' => 'Usuário não encontrado.'], 404);
        }

        if (!Hash::check($data['senha'], $user->senha)) {
            return response()->json(['ok' => false, 'message' => 'Senha incorreta.'], 401);
        }

        return response()->json(['ok' => true, 'user' => $user]);
    }
}
