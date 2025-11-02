<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarroFotoRequest;
use App\Http\Resources\CarroFotoResource;
use App\Models\{Carro, CarroFoto};

class CarroFotoController extends Controller
{
    public function index(Carro $carro)
    {
        return CarroFotoResource::collection($carro->fotos()->orderBy('principal','desc')->orderBy('orden')->get());
    }

    public function store(StoreCarroFotoRequest $request, Carro $carro)
    {
        $foto = $carro->fotos()->create($request->validated());
        return new CarroFotoResource($foto);
    }

    public function destroy(Carro $carro, CarroFoto $foto)
    {
        abort_unless($foto->carro_id === $carro->id, 404);
        $foto->delete();
        return response()->noContent();
    }

    public function setPrincipal(Carro $carro, CarroFoto $foto)
    {
        abort_unless($foto->carro_id === $carro->id, 404);
        $carro->fotos()->update(['principal' => false]);
        $foto->update(['principal' => true]);
        return new CarroFotoResource($foto);
    }
}
