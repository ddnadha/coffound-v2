<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Favourite;
use App\Models\Province;
use App\Models\Review;
use App\Models\ReviewImage;
use App\Models\ReviewMessage;
use App\Models\Visit;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            ->take(4)
            ->where('id', '!=', $cafe->id)
            ->where('status', 'active')
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
        $province = Province::all();
        return view('pages.mobile.form', compact('province'));
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
        return view('pages.mobile.profile');
    }

    public function menu(Request $request, $name)
    {
        $cafe = Cafe::where('name', str_replace('_', ' ', $name))->first();
        if ($cafe == null) abort(404);
        return view('pages.mobile.menu', compact('cafe'));
    }

    public function makeFav(Request $request)
    {
        $q = Favourite::query()
            ->where('user_id', auth()->id())
            ->where('cafe_id', $request->cafe);
        if (!$q->exists()) {
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

    public function createReview(Cafe $cafe)
    {
        return view('pages.mobile.review', compact('cafe'));
    }

    public function storeReview(Cafe $cafe, Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->has('review_id')) {
                $review = Review::findOrFail($request->review_id);
            } else {
                //save review to database
                $review = new Review();
                $review->cafe_id = $cafe->id;
                $review->user_id = auth()->id();
                $review->rating = $request->rate;
                $review->save();

                $cafe->rating = Review::where('cafe_id', $cafe->id)->whereDoesntHave('report')->avg('rating') ?? 0;
                $cafe->save();
            }

            //save message of review to database
            $review_msg = new ReviewMessage();
            $review_msg->review_id = $review->id;
            $review_msg->user_id = auth()->id();
            $review_msg->message = $request->review;
            $review_msg->save();

            //save image of message
            $image = $request->file('image');
            if (is_array($image)) {
                foreach ($image as $i) {
                    $imageName = uniqid() . $i->getClientOriginalName();
                    $i->move(public_path('storage/review'), $imageName);

                    $img = new ReviewImage();
                    $img->review_message_id = $review_msg->id;
                    $img->img = 'storage/review/' . $imageName;
                    $img->save();
                }
            }

            DB::commit();
            return redirect()->to("mobile/caffee/" . str_replace(" ", "_", $cafe->name))->with('success', 'Berhasil menambahkan review');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            dd($e->getMessage());
        }
    }
}
