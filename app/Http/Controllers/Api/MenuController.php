<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    //
    public function show($id)
    {
        $menu = Menu::find($id);
        $menu->{'image'} = asset($menu->main_image);
        $menu->{'price'} = 'Rp. ' . number_format($menu->price, 0, '.', '.');
        if ($menu) {
            return response()->json([
                'status' => true,
                'data' => $menu
            ]);
        } else {
            return response()->json([
                'status' => false,
                'data' => 'not found'
            ]);
        }
    }
}
