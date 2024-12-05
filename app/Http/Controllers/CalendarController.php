<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{

    public function getEvents()
    {
        try {
            $events = Calendar::where('user_id', Auth::id())
                ->get()
                ->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'start' => $event->date->format('Y-m-d'),
                        'color' => $event->color,
                        'extendedProps' => [
                            'description' => $event->description,
                            'amount' => $event->amount
                        ]
                    ];
                });

            return response()->json($events);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }
    public function addAmount(Request $request)
    {
        try {
            $calendar = Calendar::create([
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,
                'amount' => $request->amount,
                'color' => '#28a745',
                'user_id' => Auth::user()->id
            ]);

            return response()->json([
                'success' => true,
                'data' => $calendar
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el registro'
            ], 500);
        }
    }

    public function updateAmount(Request $request)
    {
        try {
            $calendar = Calendar::find($request->id);
            if ($calendar->date->format('Y-m-d') !== now()->format('Y-m-d')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo puedes editar montos del día actual'
                ], 403);
            }
    
            $calendar->update([
                'amount' => $request->amount,
                'title' => '$' . $request->amount
            ]);
    
            return response()->json([
                'success' => true,
                'data' => $calendar
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el registro'
            ], 500);
        }
    }
}
