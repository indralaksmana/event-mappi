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

    }

    public function edit(Request $request) {
        
    }

    public function update(Request $request) {
        
    }

    public function delete(Request $request) {
        
    }
}
