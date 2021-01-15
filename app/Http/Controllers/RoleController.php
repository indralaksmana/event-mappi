<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function read(Request $request) {
        
        try {
            
            $role = Role::all();
            
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $role
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
            
            $role = new Role();
            $role->name = $payLoad['name']; 
            $role->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Role successfully added',
                'data' => $role
            ], 201);

        } catch(\Exception $err) {

            return response()->json([
                'success' => false,
                'message' => $err->getMessage(),
                'data' => []
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
