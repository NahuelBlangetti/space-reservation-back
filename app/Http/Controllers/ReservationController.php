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


            // Verifica disponibilidad del espacio
            $overlapping = Reservations::where('space_id', $validated['space_id'])
                ->where('id', '!=', $Reservations->id)
                ->where(function ($query) use ($validated) {
                    $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                        ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
                })
                ->exists();
    
            
            if ($overlapping) {
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

            $user = Auth::user();
            
            if ($user->is_admin === true) {
                return $Reservations;
            }

            if ($Reservations->user_id !== $user->id) {
                return response()->json(['message' => 'No autorizado.'], 403);
            }
    
            return $Reservations;
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function update(Request $request, Reservations $Reservations)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'space_id' => 'required|exists:spaces,id',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]);
            
            // Verifica disponibilidad del espacio
            $overlapping = Reservations::where('space_id', $validated['space_id'])
                ->where('id', '!=', $Reservations->id)
                ->where(function ($query) use ($validated) {
                    $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                        ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
                })
                ->exists();
        
            if ($overlapping) {
                return response()->json(['message' => 'La reserva se superpone con otra existente.'], 409);
            }
            
            // Convertir las fechas al formato correcto
            $validated['start_time'] = date('Y-m-d H:i:s', strtotime($validated['start_time']));
            $validated['end_time'] = date('Y-m-d H:i:s', strtotime($validated['end_time']));
    
            // Actualizar la reserva
            $reservationUpdate = Reservations::where('user_id', $validated['user_id'])
                                             ->where('space_id', $validated['space_id'])
                                             ->update($validated);
    
            return response()->json($reservationUpdate);
            
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    
    

    public function destroy($id)
    {
        try {

            $user = Auth::user();
            if ($user->is_admin === true) {
                $reservation = Reservations::findOrFail($id);
            }else {
                $reservation = Reservations::where('user_id', auth()->id())->findOrFail($id);
            }

            $reservation->delete();
    
            return response()->json([
                'message' => 'Reserva eliminada con éxito',
            ], 204);
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
