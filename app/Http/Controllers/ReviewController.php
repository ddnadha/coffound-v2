<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\ReportReview;
use App\Models\Review;
use App\Models\ReviewMessage;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cafe $cafe = null)
    {
        if ($cafe == null) {
            $review = ReportReview::query()->latest()->get();
            return view('pages.report.review.index', compact('review'));
        } else {
            $review = Review::query()->where('cafe_id', $cafe->id)->latest()->get();
            return view('pages.owner.review', compact('cafe', 'review'));
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
        //
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
    public function destroy($id)
    {
        //
    }

    public function reply(Cafe $cafe, Request $request)
    {
        $rm = new ReviewMessage();
        $rm->review_id = $request->review_id;
        $rm->user_id = auth()->id();
        $rm->message = $request->message;
        $rm->save();

        return redirect()->back()->with('success', 'Berhasil membalas review');
    }
}
