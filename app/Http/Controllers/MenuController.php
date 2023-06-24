<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\CafeImage;
use App\Models\Menu;
use App\Models\MenuImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cafe $cafe = null)
    {
        if ($cafe != null) {
            return view('pages.owner.menu', compact('cafe'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Cafe $cafe)
    {
        return view('pages.owner.form-menu', compact('cafe'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Cafe $cafe, Request $request)
    {
        DB::beginTransaction();
        try {
            $menu = new Menu();
            $menu->cafe_id = $cafe->id;
            $menu->name = $request->name;
            $menu->desc = $request->desc;
            $menu->price = $request->price;
            $menu->save();

            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('storage/menu'), $imageName);

            $imageUpload = new MenuImage();
            $imageUpload->is_priority = !MenuImage::where('menu_id', $menu->id)->exists();
            $imageUpload->menu_id = $menu->id;
            $imageUpload->img = 'storage/menu/' . $imageName;
            $imageUpload->save();

            DB::commit();

            return redirect()->route('owner.menu.index', $cafe)->with('success', 'Berhasil menambahkan menu');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan data - ' . $e->getMessage());
        }
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
    public function edit(Cafe $cafe, $id)
    {
        $menu = Menu::query()->find($id);
        return view('pages.owner.form-menu', compact('cafe', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Cafe $cafe, $id, Request $request)
    {
        DB::beginTransaction();
        try {
            $menu = Menu::query()->find($id);
            $menu->name = $request->name;
            $menu->desc = $request->desc;
            $menu->price = $request->price;
            $menu->save();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('storage/menu'), $imageName);
                $imageUpload = MenuImage::query()->where('img', $menu->main_image)->firstOrFail();
                $imageUpload->img = 'storage/menu/' . $imageName;
                $imageUpload->save();
                // dd($imageUpload);
            }

            DB::commit();

            return redirect()->route('owner.menu.index', $cafe)->with('success', 'Berhasil mengubah data menu');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengubah data - ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cafe $cafe, $id)
    {
        Menu::query()->find($id)->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus menu');
    }
}
