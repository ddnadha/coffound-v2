<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryCafe;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $q = CategoryCafe::where('cafe_id', $request->cafe)
                ->where('category_id', $request->category);
        if(!$q->exists()){
            $cat = new CategoryCafe;
            $cat->cafe_id = $request->cafe;
            $cat->category_id = $request->category;
            $cat->save();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil menambahkan kategori'
            ]);
        }else{
            $q->delete();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil menghapus kategori'
            ]);
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
