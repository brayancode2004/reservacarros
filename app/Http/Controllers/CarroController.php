<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreCarroRequest, UpdateCarroRequest};
use App\Http\Resources\CarroResource;
use App\Models\Carro;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    public function index(Request $request)
    {
        $q = Carro::query()->with(['sucursal','fotos' => fn($qq) => $qq->orderBy('principal','desc')->orderBy('orden')]);

        if ($s = $request->query('search')) {
            $q->where(function($qq) use ($s) {
                $qq->where('placa','like',"%{$s}%")
                   ->orWhere('marca','like',"%{$s}%")
                   ->orWhere('modelo','like',"%{$s}%");
            });
        }
        if ($estado = $request->query('estado')) $q->where('estado',$estado);
        if ($suc = $request->query('sucursal_id')) $q->where('sucursal_id',$suc);

        return CarroResource::collection($q->orderByDesc('id')->paginate(10));
    }

    public function store(StoreCarroRequest $request)
    {
        $carro = Carro::create($request->validated());
        return new CarroResource($carro->load('sucursal'));
    }

    public function show(Carro $carro)
    {
        return new CarroResource($carro->load(['sucursal','fotos' => fn($q)=>$q->orderBy('principal','desc')->orderBy('orden')]));
    }

    public function update(UpdateCarroRequest $request, Carro $carro)
    {
        $carro->update($request->validated());
        return new CarroResource($carro->load('sucursal'));
    }

    public function destroy(Carro $carro)
    {
        $carro->delete();
        return response()->noContent();
    }
}
