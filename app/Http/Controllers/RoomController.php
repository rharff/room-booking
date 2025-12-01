<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('facilities', 'like', "%{$search}%");
            });
        }

        if ($request->filled('capacity')) {
            $capacity = $request->input('capacity');
            $query->where('capacity', '>=', $capacity);
        }

        $rooms = $query->paginate(9)->withQueryString();

        return view('rooms.index', compact('rooms'));
    }

    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }
}
