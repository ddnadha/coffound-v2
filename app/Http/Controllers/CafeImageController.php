<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\CafeImage;
use Illuminate\Http\Request;

class CafeImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cafe $cafe)
    {
        return view('pages.owner.image', compact('cafe'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Cafe $cafe)
    {
        return view('pages.owner.form-image', compact('cafe'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Cafe $cafe, Request $request)
    {
        $images = $request->file('file');
        foreach ($images as $image) {
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('storage/cafe'), $imageName);

            $imageUpload = new CafeImage();
            $imageUpload->is_priority = !CafeImage::where('cafe_id', $cafe->id)->exists();
            $imageUpload->cafe_id = $cafe->id;
            $imageUpload->img = 'storage/cafe/' . $imageName;
            $imageUpload->save();
        }

        return response()->json(['success' => $imageName]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cafe $cafe, $id)
    {
        CafeImage::query()->find($id)->delete();
        return redirect()->back()->with('success', 'Berhasil Menghapus foto');
    }
}
