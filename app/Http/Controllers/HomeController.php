<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Menu;
use App\Models\Review;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->priv == 'admin') return $this->admin();
        if (auth()->user()->priv == 'pemilik_cafe') return $this->owner();
        if (auth()->user()->priv == 'user') return redirect()->to('/mobile/home');
    }

    public function admin()
    {
        $data['jumlah_cafe'] = Cafe::query()->where('status', 'active')->count();
        $data['jumlah_visit'] = Visit::query()->whereHas('cafe')->sum('visit');
        $data['jumlah_review'] = Review::query()->whereHas('cafe')->count();
        $data['jumlah_user'] = User::query()->count();

        foreach (Cafe::all() as $cafe) {
            $weeklyVisitation = Visit::query()->where('cafe_id', $cafe->id)
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->get();
            $lastWeeklyVisitation = Visit::query()->where('cafe_id', $cafe->id)
                ->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
                ->get();
            $data['cafe'][$cafe->id]['visitation'] = [0, 0, 0, 0, 0, 0, 0];

            $data['cafe'][$cafe->id]['cafe'] = $cafe;
            foreach ($weeklyVisitation as $ws) {
                $data['cafe'][$cafe->id]['visitation'][intval($ws->visit_date->format('N')) - 1] = $ws->visit;
            }
            $data['cafe'][$cafe->id]['visitation'] = json_encode($data['cafe'][$cafe->id]['visitation']);
            $data['cafe'][$cafe->id]['jumlah_visitor'] = $weeklyVisitation->sum('visit');
            $data['cafe'][$cafe->id]['jumlah_visitor_old'] = $lastWeeklyVisitation->sum('visit');
            $data['cafe'][$cafe->id]['jumlah_review'] = Review::query()->where('cafe_id', $cafe->id)->count();
            $data['cafe'][$cafe->id]['jumlah_rating'] = Review::query()->where('cafe_id', $cafe->id)->avg('rating');
            $data['cafe'][$cafe->id] = (object) $data['cafe'][$cafe->id];
        }

        $data['jumlah_visitor_all'] = Visit::query()->whereHas('cafe')->sum('visit');
        $data['visitor_all'] = Visit::query()->select(DB::raw('cafe_id, SUM(visit) as visit'))
            ->whereHas('cafe')
            ->groupBy('cafe_id')
            ->orderBy('visit', 'DESC')
            ->limit(3)
            ->get();

        return view('pages.admin.index', $data);
    }

    public function owner()
    {
        $data['jumlah_cafe'] = Cafe::where('user_id', auth()->id())->count();
        $data['jumlah_menu'] = Menu::whereHas('cafe', function ($q) {
            $q->where('user_id', auth()->id());
        })->count();
        $data['jumlah_review'] = Review::whereHas('cafe', function ($q) {
            $q->where('user_id', auth()->id());
        })->count();
        $data['jumlah_rating'] = Review::whereHas('cafe', function ($q) {
            $q->where('user_id', auth()->id());
        })->avg('rating');

        foreach (Cafe::where('user_id', auth()->id())->get() as $cafe) {
            $weeklyVisitation = Visit::where('cafe_id', $cafe->id)
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->get();
            $lastWeeklyVisitation = Visit::where('cafe_id', $cafe->id)
                ->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
                ->get();
            $data['cafe'][$cafe->id]['visitation'] = [0, 0, 0, 0, 0, 0, 0];

            $data['cafe'][$cafe->id]['cafe'] = $cafe;
            foreach ($weeklyVisitation as $ws) {
                $data['cafe'][$cafe->id]['visitation'][intval($ws->visit_date->format('N')) - 1] = $ws->visit;
            }
            $data['cafe'][$cafe->id]['visitation'] = json_encode($data['cafe'][$cafe->id]['visitation']);
            $data['cafe'][$cafe->id]['jumlah_visitor'] = $weeklyVisitation->sum('visit');
            $data['cafe'][$cafe->id]['jumlah_visitor_old'] = $lastWeeklyVisitation->sum('visit');
            $data['cafe'][$cafe->id]['jumlah_review'] = Review::where('cafe_id', $cafe->id)->count();
            $data['cafe'][$cafe->id]['jumlah_rating'] = Review::where('cafe_id', $cafe->id)->avg('rating');
            $data['cafe'][$cafe->id] = (object) $data['cafe'][$cafe->id];
        }

        $data['jumlah_visitor_all'] = Visit::whereHas('cafe', function ($q) {
            $q->where('user_id', auth()->id());
        })->sum('visit');
        $data['visitor_all'] = Visit::select(DB::raw('cafe_id, SUM(visit) as visit'))
            ->whereHas('cafe', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->groupBy('cafe_id')
            ->orderBy('visit', 'DESC')
            ->limit(3)
            ->get();
        return view('pages.owner.index', $data);
    }
}
