<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function read(Request $request) {
        
        try {
            
            $user = User::all();
            
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $user
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

        $payLoad = jsonRawParser($request->get('data'));

        try {

            $fileName = time().'_'.$request->photo->getClientOriginalName();
            $filePath = $request->file('photo')->storeAs('uploads', $fileName, 'public');

            $user = new User();
            $user->name = $payLoad['name'];
            $user->email = $payLoad['email'];
            $user->password = $payLoad['password'];
            $user->sector = $payLoad['sector'];
            $user->department = $payLoad['department'];
            $user->role = $payLoad['role'];
            $user->notes = $payLoad['notes'];
            $user->photo = '/storage/' . $filePath;
            $user->createdBy = auth()->user()->_id;
            $user->updatedBy = null;
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

    public function edit(Request $request) {
        
    }

    public function update(Request $request) {
        
    }

    public function delete(Request $request) {
        
    }
}
