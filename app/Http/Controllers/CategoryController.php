<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function read(Request $request) {
        
        try {
            
            $category = Category::all();
            
            return response()->json([
                'success' => true,
                'message' => '',
                'data' => $category
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
            
            $category = new Category();
            $category->name = $payLoad['name']; 
            $category->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Category successfully added',
                'data' => $category
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
