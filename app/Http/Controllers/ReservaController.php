<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreReservaRequest, UpdateReservaRequest};
use App\Http\Resources\ReservaResource;
use App\Models\{Reserva, Carro};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    public function index(Request $request)
    {
        $q = Reserva::query()->with(['carros','usuario']);
        if ($uid = $request->query('usuario_id')) $q->where('usuario_id',$uid);
        if ($estado = $request->query('estado')) $q->where('estado',$estado);
        return ReservaResource::collection($q->orderByDesc('id')->paginate(10));
    }

    public function store(StoreReservaRequest $request)
    {
        return DB::transaction(function() use ($request) {
            $data = $request->validated();
            $carrosData = collect($data['carros'])->keyBy('carro_id');
            unset($data['carros']);

            $reserva = Reserva::create($data);

            // armar payload para sync
            $sync = [];
            foreach ($carrosData as $carroId => $item) {
                $carro = Carro::findOrFail($carroId);
                $tarifa = $item['tarifa_diaria'] ?? $carro->tarifa_diaria;
                $dias   = $item['dias'] ?? max(1, $this->dias($data['fecha_inicio'], $data['fecha_fin']));
                $sync[$carroId] = [
                    'tarifa_diaria' => $tarifa,
                    'dias'          => $dias,
                    'subtotal'      => $tarifa * $dias,
                ];
            }
            $reserva->carros()->sync($sync);

            // precio_total
            $reserva->update([
                'precio_total' => $reserva->carros()->sum('carro_reserva.subtotal')
            ]);

            return new ReservaResource($reserva->load('carros'));
        });
    }

    public function show(Reserva $reserva)
    {
        return new ReservaResource($reserva->load('carros'));
    }

    public function update(UpdateReservaRequest $request, Reserva $reserva)
    {
        return DB::transaction(function() use ($request, $reserva) {
            $data = $request->validated();

            if (isset($data['carros'])) {
                $carrosData = collect($data['carros'])->keyBy('carro_id');
                unset($data['carros']);

                $sync = [];
                foreach ($carrosData as $carroId => $item) {
                    $carro = Carro::findOrFail($carroId);
                    $tarifa = $item['tarifa_diaria'] ?? $carro->tarifa_diaria;
                    $dias   = $item['dias'] ?? max(1, $this->dias($reserva->fecha_inicio, $reserva->fecha_fin));
                    $sync[$carroId] = [
                        'tarifa_diaria' => $tarifa,
                        'dias'          => $dias,
                        'subtotal'      => $tarifa * $dias,
                    ];
                }
                $reserva->carros()->sync($sync);
            }

            $reserva->update($data);

            // recalcular total
            $reserva->update([
                'precio_total' => $reserva->carros()->sum('carro_reserva.subtotal')
            ]);

            return new ReservaResource($reserva->load('carros'));
        });
    }

    public function destroy(Reserva $reserva)
    {
        $reserva->delete();
        return response()->noContent();
    }

    // --- rutas extra ---
    public function attachCarros(Request $request, Reserva $reserva)
    {
        $request->validate([
            'carros'               => 'required|array|min:1',
            'carros.*.carro_id'    => 'required|exists:carros,id',
            'carros.*.dias'        => 'nullable|integer|min:1',
            'carros.*.tarifa_diaria'=> 'nullable|numeric|min:0',
        ]);

        $sync = [];
        foreach ($request->carros as $item) {
            $carro = Carro::findOrFail($item['carro_id']);
            $tarifa = $item['tarifa_diaria'] ?? $carro->tarifa_diaria;
            $dias   = $item['dias'] ?? max(1, $this->dias($reserva->fecha_inicio, $reserva->fecha_fin));
            $sync[$carro->id] = [
                'tarifa_diaria' => $tarifa,
                'dias'          => $dias,
                'subtotal'      => $tarifa * $dias,
            ];
        }
        $reserva->carros()->syncWithoutDetaching($sync);
        return $this->recalcular($request, $reserva);
    }

    public function detachCarro(Reserva $reserva, Carro $carro)
    {
        $reserva->carros()->detach($carro->id);
        $reserva->update([
            'precio_total' => $reserva->carros()->sum('carro_reserva.subtotal')
        ]);
        return new ReservaResource($reserva->load('carros'));
    }

    public function recalcular(Request $request, Reserva $reserva)
    {
        $reserva->update([
            'precio_total' => $reserva->carros()->sum('carro_reserva.subtotal')
        ]);
        return new ReservaResource($reserva->load('carros'));
    }

    private function dias($inicio, $fin): int
    {
        $start = strtotime($inicio);
        $end   = strtotime($fin);
        $diff  = max(1, ceil(($end - $start) / 86400)); // mínimo 1 día
        return $diff;
    }
}
