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
        try {
            $reservations = Reservations::with(['space', 'user'])
            ->where('user_id', Auth::id())
            ->get();
    
            return response()->json([
                'success' => true,
                'reservations' => $reservations
            ]);
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
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
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show(Reservations $Reservations)
    {
        try {
            if ($Reservations->user_id !== Auth::id()) {
                return response()->json(['message' => 'No autorizado.'], 403);
            }
    
            return $Reservations;
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function update(Request $request, Reservations $reservation)
    {
        try {
            $validated = $request->validate([
                'space_id' => 'sometimes|required|exists:spaces,id',
                'start_time' => 'sometimes|required|date',
                'end_time' => 'sometimes|required|date|after:start_time',
            ]);
        
            // Verifica la superposición de reservas
            $overlapping = Reservations::where('space_id', $validated['space_id'])
                ->where('id', '<>', $reservation->id)
                ->where(function ($query) use ($validated) {
                    $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                          ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
                })
                ->exists();
        
            if ($overlapping) {
                return response()->json(['message' => 'La reserva se superpone con otra existente.'], 409);
            }
        
            $reservation->update($validated);
            return response()->json($reservation);
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    

    public function destroy($id)
    {
        try {
            $reservation = Reservations::where('user_id', auth()->id())->findOrFail($id);
            $reservation->delete();
    
            return response()->json(null, 204);
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
