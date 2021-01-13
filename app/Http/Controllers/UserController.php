<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            $user->password = Hash::make($payLoad['password']);
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

    public function update(Request $request, $id) {

        $payLoad = jsonRawParser($request->get('data'));

        try {

            $user = User::find($id);
            $user->password;
            $user->name = $payLoad['name'];
            $user->email = $payLoad['email'];
            
            if ($user->password !== $payLoad['password']) {
                $user->password = Hash::make($payLoad['password']);   
            }

            $user->sector = $payLoad['sector'];
            $user->department = $payLoad['department'];
            $user->role = $payLoad['role'];
            $user->notes = $payLoad['notes'];
            
            if ($request->hasFile('photo')) {
                $fileName = time().'_'.$request->photo->getClientOriginalName();
                $filePath = $request->file('photo')->storeAs('uploads', $fileName, 'public');
                $user->photo = '/storage/' . $filePath;
            }
            
            $user->createdBy = auth()->user()->_id;
            $user->updatedBy = null;
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => 'User successfully updated',
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

    public function delete($id) {
        try {
            
            $user = User::find($id);
            $user->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'User successfully removed',
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

    public function deleteAll(Request $request) {
        $payLoad = jsonRawParser($request->getContent());

        try {
            
            $user = User::whereIn('_id', $payLoad['userIds']);
            $user->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Users successfully removed',
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
