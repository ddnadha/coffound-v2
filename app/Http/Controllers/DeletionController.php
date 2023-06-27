<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Deletion;
use App\Models\Notif;
use Illuminate\Http\Request;

class DeletionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deletion = Deletion::query()->latest()->get();
        return view('pages.deletion.index', compact('deletion'));
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
        $del = new Deletion();
        $del->cafe_id = $cafe->id;
        $del->reason = $request->reason ?? "";
        $del->save();

        // make notif
        $notif = new Notif();
        $notif->user_id = 1;
        $notif->notification = 'Permintaan pengahapusan kafe ' . $cafe->name;
        $notif->save();

        return redirect()->back()->with('success', 'Berhasil membuat pengajuan penghapusan cafe');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deletion  $deletion
     * @return \Illuminate\Http\Response
     */
    public function show(Deletion $deletion, Request $request)
    {
        // dd($request->all());
        if ($request->has('action')) {

            $notif = new Notif();
            $notif->user_id = $deletion->cafe->user->id;

            if ($request->action) {
                $notif->notification = 'Permintaan penghapusan kafe ' . $deletion->cafe->name . ' telah disetujui';
                $deletion->status = 'accepted';

                $deletion->cafe->delete();
                $msg = 'Kafe telah berhasil dihapus';
            } else {
                $notif->notification = 'Permintaan penghapusan kafe ' . $deletion->cafe->name . ' ditolak';
                $deletion->status = 'rejected';
                $msg = 'Permintaan berhasil ditolak';
            }

            $notif->save();
            $deletion->save();

            return redirect()->back()->with('success', $msg);
        } else {
            return redirect()->back()->with('error', 'Terjadi Kesalahan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deletion  $deletion
     * @return \Illuminate\Http\Response
     */
    public function edit(Deletion $deletion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deletion  $deletion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deletion $deletion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deletion  $deletion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deletion $deletion)
    {
        //
    }
}
