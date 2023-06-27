<?php

namespace App\Http\Controllers;

use App\Models\Activation;
use App\Models\Cafe;
use App\Models\Notif;
use Illuminate\Http\Request;

class ActivationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $act = Activation::query()->latest()->get();
        return view('pages.activation.index', compact('act'));
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
    public function store(Cafe $cafe, Request $request)
    {
        $act = new Activation();
        $act->cafe_id = $cafe->id;
        $act->reason = $request->reason;
        $act->save();

        $notif = new Notif();
        $notif->user_id = 1;
        $notif->notification = 'Permintaan buka suspend untuk kafe ' . $cafe->name;
        $notif->save();

        return redirect()->back()->with('success', 'Berhasil membuat pengajuan buka suspend');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activation  $activation
     * @return \Illuminate\Http\Response
     */
    public function show(Activation $activation, Request $request)
    {
        if ($request->has('action')) {

            $notif = new Notif();
            $notif->user_id = $activation->cafe->user->id;

            if ($request->action) {
                $notif->notification = 'Permintaan pembukaan suspend kafe ' . $activation->cafe->name . ' telah disetujui';
                $activation->status = 'accepted';

                $activation->cafe->status = 'active';
                $activation->cafe->save();

                $msg = 'Kafe telah aktif kembali';
            } else {
                $notif->notification = 'Permintaan pembukaan suspend kafe ' . $activation->cafe->name . ' ditolak';
                $activation->status = 'rejected';
                $msg = 'Permintaan berhasil ditolak';
            }

            $notif->save();
            $activation->save();

            return redirect()->back()->with('success', $msg);
        } else {
            return redirect()->back()->with('error', 'Terjadi Kesalahan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activation  $activation
     * @return \Illuminate\Http\Response
     */
    public function edit(Activation $activation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activation  $activation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activation $activation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activation  $activation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activation $activation)
    {
        //
    }
}
