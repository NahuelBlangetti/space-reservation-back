<?php

namespace App\Http\Controllers;

use App\Models\Reservations;
use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function index()
    {
        return Reservations::where('user_id', Auth::id())->get();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'space_id' => 'required|exists:spaces,id',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]);


            // Validar que no haya conflictos de horarios
            $conflict = Reservations::where('space_id', $validated['space_id'])
                ->where(function ($query) use ($validated) {
                    $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                        ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
                })
                ->exists();
    
            
            if ($conflict) {
                return response()->json(['message' => 'El espacio no está disponible en ese horario'], 409);
            }
    
            $reservation = Reservations::create([
                'user_id' => auth()->id(),
                'space_id' => $validated['space_id'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
            ]);
    
            return [
                'message' => 'Reserva creada con éxito',
                'reservation' => $reservation,
            ];

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function show(Reservations $Reservations)
    {
        if ($Reservations->user_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        return $Reservations;
    }

    public function update(Request $request, Reservations $Reservations)
    {
        if ($Reservations->user_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $validated = $request->validate([
            'space_id' => 'sometimes|required|exists:spaces,id',
            'start_time' => 'sometimes|required|date',
            'end_time' => 'sometimes|required|date|after:start_time',
        ]);

        // Verificar superposición de reservas
        $overlapping = Reservations::where('space_id', $validated['space_id'])
            ->where('id', '<>', $Reservations->id) // Excluir la reserva actual
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                      ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
            })
            ->exists();

        if ($overlapping) {
            return response()->json(['message' => 'La reserva se superpone con otra existente.'], 409);
        }

        $Reservations->update($validated);
        return $Reservations;
    }

    public function destroy($id)
    {
        $reservation = Reservations::where('user_id', auth()->id())->findOrFail($id);
        $reservation->delete();

        return response()->json(null, 204);
    }
}
