<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Favourite;
use App\Models\Notif;
use App\Models\Province;
use App\Models\Review;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CafeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->priv == 'admin') {
            $cafe = Cafe::query()->orderBy('status', 'desc')->get();
            return view('pages.cafe.index', compact('cafe'));
        } else {
            $cafe = Cafe::query()->where('user_id', auth()->id())->orderBy('status', 'asc')->get();
            return view('pages.owner.cafes', compact('cafe'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $latlng = json_decode($request->latlng);

            $cafe = new Cafe;
            $cafe->district_id = $request->district;
            $cafe->name = $request->name;
            $cafe->user_id = auth()->id();
            $cafe->address = $request->address;
            $cafe->desc = $request->desc;
            $cafe->pricerange = '';
            $cafe->lat = $latlng[0];
            $cafe->lng = $latlng[1];
            $cafe->rating = 0;

            $cafe->save();

            return redirect()->to('/mobile/open')->with('success', 'Berhasil menambahkan Cafe Baru');
        } catch (Exception $e) {
            Log::error('failed storing cafe - ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi Kesalahan, pastikan data yang anda inputkan benar');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cafe $cafe)
    {
        $province = Province::all();
        if ($cafe->rating == 0) {
            $review = Review::query()->where('cafe_id', $cafe->id)->get();
            $cafe->rating = $review->avg('rating') ?? 0;
            $cafe->save();
        }
        return view('pages.owner.cafe', compact('cafe', 'province'));
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
    public function update(Cafe $cafe, Request $request)
    {
        // dd($request->all());
        try {
            $latlng = json_decode($request->latlng);
            $cafe->district_id = $request->district;
            $cafe->name = $request->name;
            $cafe->user_id = auth()->id();
            $cafe->address = $request->address;
            $cafe->desc = $request->desc;
            $cafe->pricerange = '';
            $cafe->lat = $latlng[0];
            $cafe->lng = $latlng[1];
            $cafe->rating = 0;

            $cafe->save();

            return redirect()->to('/owner/cafe/' . $cafe->id)->with('success', 'Berhasil mengubah data Cafe');
        } catch (Exception $e) {
            Log::error('failed storing cafe update - ' . $e->getLine() . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi Kesalahan, pastikan data yang anda inputkan benar');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function fav(Request $request)
    {
        $q = Favourite::where('user_id', auth()->id())->where('cafe_id', $request->cafe);
        if (!$q->exists()) {
            $fav = new Favourite();
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

    public function suspend(Request $request, Cafe $cafe)
    {
        $cafe->status = "suspended";
        $cafe->save();
        return redirect()->back()->with('success', 'Berhasil di Suspend');
    }

    public function verify(Cafe $cafe)
    {
        try {
            $notif = new Notif();
            $notif->user_id = $cafe->user_id;

            $user = User::query()->find($cafe->user_id);
            if (auth()->user()->priv == 'admin') {
                $cafe->status = 'active';
                $cafe->save();
            }

            if ($user->priv == 'user') {
                $user->priv = 'pemilik_cafe';
                $user->save();
                $notif->notification = 'Selamat! Permintaan pembukaan kafe pertama anda, ' . $cafe->name . ' telah disetujui';
            } else {
                $notif->notification = 'Permintaan pembukaan kafe ' . $cafe->name . ' telah disetujui';
            }
            $notif->save();
            return redirect()->back()->with('success', 'berhasil di verifikasi');
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function activate(Cafe $cafe)
    {
        if ($cafe->status == 'suspended') return redirect()->back()->with('error', 'Kafe anda sedang di suspend');
        elseif ($cafe->status == 'active') $cafe->status = 'deactive';
        elseif ($cafe->status == 'deactive') $cafe->status = 'active';


        $cafe->save();
        return redirect()->back()
            ->with('success', 'Berhasil ' . ($cafe->status == 'active' ?  'mengaktifkan ' : 'menonaktifkan ') . 'kafe');
    }
}
