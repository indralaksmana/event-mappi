<?php

namespace App\Http\Controllers;

use App\Event;
use App\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function readCalendar () {
        try {

            $calendarEvents = [];
            $publicEvents = Event::where('type', 'public')
                                    ->whereIn('sector', ["0" => ["id" => auth()->user()->sector['id'], "label" => auth()->user()->sector['label']]])
                                    ->get();
            $specificEvents = Event::where('type', 'specific')
                                    ->whereIn('forUsers', ["0" => ["id" => auth()->user()->_id, "label" => auth()->user()->name]])
                                    ->whereIn('sector', ["0" => ["id" => auth()->user()->sector['id'], "label" => auth()->user()->sector['label']]])
                                    ->get();
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
            $queryPublicEvents = Event::query();
            $queryPublicEvents->where('type', 'public');
            $queryPublicEvents->whereIn('sector', ["0" => ["id" => auth()->user()->sector['id'], "label" => auth()->user()->sector['label']]]);
            if ($request->has('category') && $request->input('category') !== 'all' && $request->input('category') !== null) {
                $category = Category::find($request->input('category'));
                $queryPublicEvents->whereIn('category', ["0" => ["id" => $category->_id, "label" => $category->name]]);
            }
            if ($request->has('status') && $request->input('status') !== 'all' && $request->input('status') !== null) {
                $queryPublicEvents->where('status', (int)$request->input('status'));
            }
            $publicEvents = $queryPublicEvents->get();
            
            $querySpecificEvents = Event::query();
            $querySpecificEvents->where('type', 'specific');
            $querySpecificEvents->whereIn('forUsers', ["0" => ["id" => auth()->user()->_id, "label" => auth()->user()->name]]);
            $querySpecificEvents->whereIn('sector', ["0" => ["id" => auth()->user()->sector['id'], "label" => auth()->user()->sector['label']]]);
            if ($request->has('category') && $request->input('category') !== 'all' && $request->input('category') !== null) {
                $category = Category::find($request->input('category'));
                $querySpecificEvents->whereIn('category', ["0" => ["id" => $category->_id, "label" => $category->name]]);
            }
            if ($request->has('status') && $request->input('status') !== 'all' && $request->input('status') !== null) {
                $querySpecificEvents->where('status', (int)$request->input('status'));
            }
            $specificEvents = $querySpecificEvents->get();
            
            $events = count($publicEvents) > 0 ? $publicEvents->merge($specificEvents) : $specificEvents;
            
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

    public function readDetail($id) {
        try {
            
            $event = Event::find($id);
            
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
            $event->type = $payLoad['event']['type'];
            $event->forUsers = $payLoad['event']['forUsers'];
            $event->createdBy = auth()->user()->_id;
            $event->updatedBy = null;
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
            $event->type = $payLoad['event']['type'];
            $event->forUsers = $payLoad['event']['forUsers'];
            $event->updatedBy = auth()->user()->_id;
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
