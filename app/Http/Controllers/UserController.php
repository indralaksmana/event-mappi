<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function read(Request $request) {
        try {
            
            $users = User::all();
            
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $users
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
            
            $user = new User();
            $user->name = $payLoad['user']['name'];
            $user->category = $payLoad['user']['category'];
            $user->sector = $payLoad['user']['sector'];
            $user->status = $payLoad['user']['status'];
            $user->startDate = $payLoad['user']['startDate'];
            $user->endDate = $payLoad['user']['endDate'];
            $user->timeStart = $payLoad['user']['timeStart'];
            $user->timeEnd = $payLoad['user']['timeEnd'];
            $user->place = $payLoad['user']['place'];
            $user->organizer = $payLoad['user']['organizer'];
            $user->description = $payLoad['user']['description'];
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => 'User successfully added',
                'data' => $user
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
