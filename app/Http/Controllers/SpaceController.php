<?php

namespace App\Http\Controllers;

use App\Models\Space;
use Illuminate\Http\Request;

class SpaceController extends Controller
{
    public function index()
    {
        return Space::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer',
            'type' => 'nullable|string',
        ]);

        return Space::create($validated);
    }

    public function show(Space $space)
    {
        return $space;
    }

    public function update(Request $request, Space $space)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'capacity' => 'sometimes|required|integer',
            'type' => 'sometimes|nullable|string',
        ]);

        $space->update($validated);

        return $space;
    }

    public function destroy(Space $space)
    {
        $space->delete();

        return response()->noContent();
    }

    public function listSpaces(Request $request)
    {
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
    }

    public function showSpace($id)
    {
        $space = Space::with('photos', 'availability')->findOrFail($id);
        return response()->json($space);
    }


}
