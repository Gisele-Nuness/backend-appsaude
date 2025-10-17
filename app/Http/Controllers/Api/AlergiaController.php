<?php

namespace App\Http\Controllers\Api;

use App\Models\Alergia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;


class AlergiaController extends Controller
{


    public function index(Request $request)
    {
       
        $alergias = Alergia::fromAuthUser()
            ->orderByDesc('id')
            ->get();

        return response()->json($alergias, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => ['required', 'string', 'min:2', Rule::unique('alergias')->where(fn($q) => $q->where('user_id', $request->user()->id))],
            'tipo'       => ['required', 'string', 'min:2'],
            'severidade' => ['required', 'string', 'min:2'],
        ]);


        $alergia = $request->user()->alergias()->create($data);

        return response()->json($alergia, 201);
    }


    public function show(string $id)
    {
        $alergia = Alergia::fromAuthUser()->findOrFail($id);
        return response()->json($alergia);
    }


    public function update(Request $request, string $id)
    {
        $alergia = Alergia::fromAuthUser()->findOrFail($id);

        $data = $request->validate([
            'nome' => ['required', 'string', 'min:2', Rule::unique('alergias')->where(fn($q) => $q->where('user_id', $request->user()->id))],
            'tipo'       => ['sometimes', 'required', 'string', 'max:255'],
            'severidade' => ['sometimes', 'required', 'string', 'max:255'],
        ]);

        $alergia->update($data);

        return response()->json($alergia, 200);
    }


    public function destroy(string $id)
    {
        $alergia = Alergia::fromAuthUser()->findOrFail($id);
        $alergia->delete();

        return response()->json(null, 204);
    }
}
