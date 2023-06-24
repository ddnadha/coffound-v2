<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\CafeUrl;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cafe $cafe = null)
    {
        if ($cafe != null) {
            return view('pages.owner.url', compact('cafe'));
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
    public function store(Cafe $cafe, Request $request)
    {
        $client = new Client();
        $psReq = new Psr7Request('GET', 'https://www.tiktok.com/oembed?url=' . $request->url);
        $res = $client->sendAsync($psReq)->wait();
        $result = json_decode($res->getBody());

        $contents = $this->getFileFromUrl($result->thumbnail_url);
        $uid = uniqid();
        Storage::put("public/tiktok/" . $uid . ".jpg", $contents);
        if ($result->type == 'video') {
            $url = new CafeUrl();
            $url->cafe_id = $cafe->id;
            $url->type = $result->type;
            $url->url = $request->url;
            $url->html = $result->html;
            $url->thumbnail = "storage/tiktok/" . $uid . ".jpg";
            $url->save();

            return redirect()->back()->with('success', 'Video berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Tautan tidak valid');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cafe $cafe, $id)
    {
        CafeUrl::query()->find($id)->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
