<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function read(Request $request) {
        try {
            
            $event = Event::all();
            
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $event
            ], 200);

        } catch(\Exception $err) {

            return response()->json([
                'success' => false,
                'message' => $err->getMessage(),
                'data' => []
            ]);
        }
    }
    
    public function store(Request $request) {
        $payLoad = jsonRawParser($request->getContent());

        try {
            
            $event = new Event();
            $event->name = $payLoad['event']['name'];
            $event->category = $payLoad['event']['category'];
            $event->sector = $payLoad['event']['sector'];
            $event->status = $payLoad['event']['status'];
            $event->startDate = $payLoad['event']['startDate'];
            $event->endDate = $payLoad['event']['endDate'];
            $event->time = $payLoad['event']['time'];
            $event->place = $payLoad['event']['place'];
            $event->organizer = $payLoad['event']['organizer'];
            $event->description = $payLoad['event']['description'];
            $event->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Event successfully added',
                'data' => $event
            ], 201);

        } catch(\Exception $err) {

            return response()->json([
                'success' => false,
                'message' => $err->getMessage(),
                'data' => $payLoad
            ], 500);
        }
    }

    public function update(Request $request, $id) {
        $payLoad = jsonRawParser($request->getContent());

        try {
            
            $event = Event::find($id);
            $event->name = $payLoad['event']['name'];
            $event->category = $payLoad['event']['category'];
            $event->sector = $payLoad['event']['sector'];
            $event->status = $payLoad['event']['status'];
            $event->startDate = $payLoad['event']['startDate'];
            $event->endDate = $payLoad['event']['endDate'];
            $event->time = $payLoad['event']['time'];
            $event->place = $payLoad['event']['place'];
            $event->organizer = $payLoad['event']['organizer'];
            $event->description = $payLoad['event']['description'];
            $event->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Event successfully updated',
                'data' => $event
            ], 201);

        } catch(\Exception $err) {

            return response()->json([
                'success' => false,
                'message' => $err->getMessage(),
                'data' => $payLoad
            ], 500);
        }
    }

    public function delete($id) {
        try {
            
            $event = Event::find($id);
            $event->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Event successfully removed',
                'data' => $event
            ], 200);

        } catch(\Exception $err) {

            return response()->json([
                'success' => false,
                'message' => $err->getMessage(),
                'data' => []
            ]);
        }
    }
}
