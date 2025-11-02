<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StorePagoRequest, UpdatePagoRequest};
use App\Http\Resources\PagoResource;
use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        $q = Pago::query();
        if ($rid = $request->query('reserva_id')) $q->where('reserva_id',$rid);
        return PagoResource::collection($q->orderByDesc('id')->paginate(10));
    }

    public function store(StorePagoRequest $request)
    {
        $pago = Pago::create($request->validated());
        return new PagoResource($pago);
    }

    public function show(Pago $pago)
    {
        return new PagoResource($pago);
    }

    public function update(UpdatePagoRequest $request, Pago $pago)
    {
        $pago->update($request->validated());
        return new PagoResource($pago);
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();
        return response()->noContent();
    }
}
