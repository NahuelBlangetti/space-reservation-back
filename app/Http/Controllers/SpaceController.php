<?php

namespace App\Http\Controllers;

use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SpaceController extends Controller
{
    public function index()
    {
        $space = Space::with(['reservations'])->where('is_available', true)->get();
        return response()->json($space);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'capacity' => 'required|integer',
                'type' => 'nullable|string',
                'photo' => 'nullable|string|url',
            ]);
    
            return Space::create($validated);
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function update(Request $request, Space $space)
    {

        Log::info('ID del espacio recibido', ['id' => $space->id]);

        try {
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|nullable|string',
                'capacity' => 'sometimes|required|integer',
                'type' => 'sometimes|nullable|string',
                'photo' => 'sometimes|nullable|string|url',
            ]);

            Log::info('Datos validados', ['validated' => $validated]);

            Log::info('Antes de la actualización', ['space' => $space->makeHidden(['reservations'])]);

            $space->update($validated);

            Log::info('Después de la actualización', ['space' => $space->makeHidden(['reservations'])]);

            return response()->json([
                'message' => 'Espacio actualizado correctamente',
                'space' => $space->makeHidden(['reservations']),
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    

    public function updateAvailable(Space $space)
    {
        try {
            $space->is_available = false;
            
            $space->save();
    
            return response()->noContent();
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    
    public function destroy(Space $space)
    {
        try {
            $space->delete();
            return response()->noContent();
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }


    public function listSpaces(Request $request)
    {
        try {
            $spaces = Space::query();

            if ($request->filled('space_type')) {
                $spaces->where('type', $request->space_type);
            }
    
            if ($request->filled('capacity')) {
                $spaces->where('capacity', '>=', $request->capacity);
            }
    
            if ($request->filled(['start_date', 'end_date'])) {
                $spaces->whereDoesntHave('reservations', function ($query) use ($request) {
                    $query->whereBetween('start_time', [$request->start_date, $request->end_date])
                        ->orWhereBetween('end_time', [$request->start_date, $request->end_date]);
                });
            }
    
            return response()->json($spaces->get());
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function showSpace($id)
    {
        try {
            $space = Space::findOrFail($id);
            return response()->json($space);
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }


}
