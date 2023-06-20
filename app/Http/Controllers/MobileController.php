<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Favourite;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MobileController extends Controller
{
    //

    public function index(Request $request)
    {
        return view('pages.mobile.home');
    }

    public function discover(Request $request)
    {
        return view('pages.mobile.discover');
    }

    public function show(Request $request, $name)
    {
        $cafe = Cafe::where('name', str_replace('_', ' ', $name))->first();
        if ($cafe == null) abort(404);

        // add visit number
        if (!auth()->check() or auth()->id() != $cafe->user_id) {
            $dbVisit = Visit::where('cafe_id', $cafe->id)->whereDate('visit_date', Carbon::today());
            if ($dbVisit->exists()) {
                $visit = $dbVisit->first();
            } else {
                $visit = new Visit;
                $visit->cafe_id = $cafe->id;
                $visit->visit_date = Carbon::today();
                $visit->visit = 0;
            }

            $visit->visit += 1;
            $visit->save();
        }

        //other cafe
        $othercafe = Cafe::selectRaw(
            "*, ( 6371 * acos( cos( radians(" . $cafe->lat . ") ) * cos( radians( lat ) ) * 
            cos( radians( lng ) - radians(" . $cafe->lng . ") ) + sin( radians(" . $cafe->lat . ") ) * 
            sin( radians( lat ) ) ) ) AS distance"
        )
            ->orderByRaw('distance')
            ->take(3)
            ->where('id', '!=', $cafe->id)
            ->get();

        $cafe->{'is_fav'} = Favourite::where('cafe_id', $cafe->id)->where('user_id', auth()->id())->exists();
        return view('pages.mobile.cafe', compact('cafe', 'othercafe'));
    }

    public function open(Request $request)
    {
        if (auth()->check() and auth()->user()->priv == 'pemilik_cafe') {
            $cafes = Cafe::where('user_id', auth()->id())->get();
            return view('pages.mobile.cafes', compact('cafes'));
        } else {
            return view('pages.mobile.open');
        }
    }

    public function openForm(Request $request)
    {
    }

    public function fav(Request $request)
    {
        $cafes = Cafe::whereHas('favourite', function ($q) {
            $q->where('user_id', auth()->id());
        })->get();
        return view('pages.mobile.fav', compact('cafes'));
    }

    public function profile(Request $request)
    {
    }

    public function menu(Request $request)
    {
    }
}
