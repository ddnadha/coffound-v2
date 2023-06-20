<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;

class GeoController extends Controller
{
    public function province()
    {
        $prov = Province::all();
        return response()->json($prov);
    }

    public function city(Request $request)
    {
        $city = Regency::where('province_id', $request->province)->get();
        foreach ($city as $c) $c->name = ucwords(strtolower($c->name));
        return response()->json($city);
    }

    public function district(Request $request)
    {
        $district = District::where('regency_id', $request->city)->get();
        foreach ($district as $d) $d->name = ucwords(strtolower($d->name));
        return response()->json($district);
    }
}
