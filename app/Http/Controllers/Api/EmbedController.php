<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CafeUrl;
use Illuminate\Http\Request;

class EmbedController extends Controller
{
    //
    public function show(CafeUrl $url){
        return response()->json($url);
    }
}
