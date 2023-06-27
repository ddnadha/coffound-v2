<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Models\CategoryCafe;
use App\Models\Favourite;
use Illuminate\Http\Request;

class CafeController extends Controller
{
    public function index(Request $request)
    {
        $cafe = Cafe::selectRaw(
            "*, ( 6371 * acos( cos( radians(" . $request->lat . ") ) * cos( radians( lat ) ) * 
                cos( radians( lng ) - radians(" . $request->lng . ") ) + sin( radians(" . $request->lat . ") ) * 
                sin( radians( lat ) ) ) ) AS distance"
        )
            ->orderByRaw('distance')
            ->where('status', 'active');

        if ($request->has('category')) {
            $cafe = $cafe->whereHas('category', function ($q) use ($request) {
                $q->whereHas('category', function ($qu) use ($request) {
                    $qu->where('name', strtolower($request->category));
                });
            });
        }
        $data['cafe'] = $cafe->get();
        foreach ($data['cafe'] as $c) {
            $c->img = asset($c->main_image);
            $c->district = $c->district->name;
        }
        return response()->json([
            'status' => true,
            'data' => $data['cafe'],
        ]);
    }

    public function fav(Request $request)
    {
        $q = Favourite::where('user_id', auth()->id())->where('cafe_id', $request->cafe);
        if ($q->exists()) {
            $fav = new Favourite;
            $fav->user_id = auth()->id();
            $fav->cafe_id = $request->cafe;
            $fav->save();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil menambahkan cafe ke daftar favorit'
            ]);
        } else {
            $q->delete();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil menghapus cafe dari daftar favorit'
            ]);
        }
    }

    public function show($id)
    {
        $cafe = Cafe::find($id);
        if ($cafe) {
            $cafe->{'img'} = asset($cafe->main_image);
            $cafe->{'whatsapp_url'} = 'https://wa.me/+62' . ltrim($cafe->user->phone, '0');
            $cafe->{'url'} = route('caffee.show') . '/' . str_replace(' ', '_', $cafe->name);
            return response()->json([
                'status' => true,
                'data' => $cafe,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Kafe Tidak Ditemukan',
            ]);
        }
    }
}
