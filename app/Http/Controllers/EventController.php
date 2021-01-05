<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function readCalendar ($userId) {
        try {

            $calendarEvents = [];
            $publicEvents = Event::where('type', 'public')->get();
            $specificEvents = Event::where('type', 'specific')->whereIn('forUsers', [$userId])->get();
            $events = $publicEvents->merge($specificEvents);
            
            $i = 0;
            foreach($events as $event) {
                $calendarEvents[$i]['classes'] = "event-success";
                $calendarEvents[$i]['id'] = $event['_id'];
                $calendarEvents[$i]['label'] = "business";
                $calendarEvents[$i]['title'] = $event['name'];
                $calendarEvents[$i]['startDate'] = $event['startDate'];
                $calendarEvents[$i]['endDate'] = $event['endDate'];
                $calendarEvents[$i]['url'] = "";

                $i++;
            }

            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $calendarEvents
            ], 200);

        } catch(\Exception $err) {

            return response()->json([
                'success' => false,
                'message' => $err->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public function read(Request $request) {
        try {
            
            $events = Event::all();
            
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $events
            ], 200);

        } catch(\Exception $err) {

            return response()->json([
                'success' => false,
                'message' => $err->getMessage(),
                'data' => []
            ], 500);
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
            $event->timeStart = $payLoad['event']['timeStart'];
            $event->timeEnd = $payLoad['event']['timeEnd'];
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
            $event->timeStart = $payLoad['event']['timeStart'];
            $event->timeEnd = $payLoad['event']['timeEnd'];
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
            ], 500);
        }
    }

    public function deleteAll(Request $request) {
        $payLoad = jsonRawParser($request->getContent());

        try {
            
            $event = Event::whereIn('_id', $payLoad['eventIds']);
            $event->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Events successfully removed',
                'data' => []
            ], 200);

        } catch(\Exception $err) {

            return response()->json([
                'success' => false,
                'message' => $err->getMessage(),
                'data' => []
            ], 500);
        }
    }
}
