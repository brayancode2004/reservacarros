<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreSucursalRequest, UpdateSucursalRequest};
use App\Http\Resources\SucursalResource;
use App\Models\Sucursal;

class SucursalController extends Controller
{
    public function index()
    {
        return SucursalResource::collection(Sucursal::orderBy('nombre')->paginate(20));
    }

    public function store(StoreSucursalRequest $request)
    {
        $s = Sucursal::create($request->validated());
        return new SucursalResource($s);
    }

    public function show(Sucursal $sucursal)
    {
        return new SucursalResource($sucursal);
    }

    public function update(UpdateSucursalRequest $request, Sucursal $sucursal)
    {
        $sucursal->update($request->validated());
        return new SucursalResource($sucursal);
    }

    public function destroy(Sucursal $sucursal)
    {
        $sucursal->delete();
        return response()->noContent();
    }
}
