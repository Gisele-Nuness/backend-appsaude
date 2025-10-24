<?php

namespace App\Http\Controllers\Api;

use App\Models\Glicemia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GlicemiaController extends Controller
{
    public function index(Request $request)
    {
        $glicemias = Glicemia::fromAuthUser()
            ->orderByDesc('data_glicemia')
            ->get();

        return response()->json($glicemias, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'valor' => ['required', 'numeric', 'between:0,999.99'],
            'observacao' => ['nullable', 'string', 'max:255'],
            'data_glicemia' => ['nullable', 'date'],
        ]);

        $data['user_id'] = $request->user()->id;

        if (empty($data['data_glicemia'])) {
            $data['data_glicemia'] = now();
        }

        $glicemia = Glicemia::create($data);

        return response()->json($glicemia, 201);
    }

    public function show(string $id)
    {
        $glicemia = Glicemia::fromAuthUser()->findOrFail($id);
        return response()->json($glicemia);
    }

    public function update(Request $request, string $id)
    {
        $glicemia = Glicemia::fromAuthUser()->findOrFail($id);

        $data = $request->validate([
            'valor' => ['sometimes', 'required', 'numeric', 'between:0,999.99'],
            'observacao' => ['sometimes', 'nullable', 'string', 'max:255'],
            'data_glicemia' => ['sometimes', 'required', 'date'],
        ]);

        $glicemia->update($data);

        return response()->json($glicemia, 200);
    }

    public function destroy(string $id)
    {
        $glicemia = Glicemia::fromAuthUser()->findOrFail($id);
        $glicemia->delete();

        return response()->json(null, 204);
    }
}
