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
            'caminho_foto'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
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

        $path = '';
        if ($request->File('caminho_foto')) {
            $path = $request->file('caminho_foto')->store('images', 'public');
        }
        $data['caminho_foto'] = $path;

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

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['ok' => false, 'message' => 'Usuário não encontrado.'], 404);
        }

        $data = $request->validate([
            'nome'         => ['sometimes', 'nullable', 'string', 'min:2'],
            'data_nasc'    => ['sometimes', 'nullable', 'date'],
            'peso'         => ['sometimes', 'nullable', 'numeric'],
            'altura'       => ['sometimes', 'nullable', 'numeric'],
            'tipo_sangue'  => ['sometimes', 'nullable', 'string', 'max:5'],
            'caminho_foto' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'cep'          => ['sometimes', 'nullable', 'string', 'max:9'],
            'logradouro'   => ['sometimes', 'nullable', 'string'],
            'numero'       => ['sometimes', 'nullable', 'string'],
            'bairro'       => ['sometimes', 'nullable', 'string'],
            'cidade'       => ['sometimes', 'nullable', 'string'],
            'email'        => ['sometimes', 'nullable', 'email', "unique:users,email,{$id}"],
            'senha'        => ['sometimes', 'nullable', 'string', 'min:6'],
        ]);

        if (isset($data['senha'])) {
           
            $data['senha'] = bcrypt($data['senha']);
        }

        if ($request->File('caminho_foto')) {
            $path = $request->file('caminho_foto')->store('images', 'public');
            $data['caminho_foto'] = $path;
        }

        $user->update($data);

        return response()->json($user);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['ok' => false, 'message' => 'Usuário não encontrado.'], 404);
        }

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['ok' => false, 'message' => 'Usuário não encontrado.'], 404);
        }

        $user->delete();

        return response()->json(['ok' => true, 'message' => 'Usuário deletado com sucesso.']);
    }
}
