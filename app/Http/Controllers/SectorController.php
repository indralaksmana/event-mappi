<?php

namespace App\Http\Controllers;

use App\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function read(Request $request) {
        
        try {
            
            $sector = Sector::all();
            
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $sector
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
            
            $sector = new Sector();
            $sector->name = $payLoad['name']; 
            $sector->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Sector successfully added',
                'data' => $sector
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
