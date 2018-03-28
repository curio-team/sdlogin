<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;
use Auth;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('links.index')->with('links', Link::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('links.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'short' => 'nullable|alpha_dash',
            'url' => 'required|url'
        ]);

        $link = new Link();
        $link->short = $request->short ?? $this->getRandomCode();
        $link->url = $request->url;
        $link->on_frontpage = false;
        $link->creator = Auth::user()->id;
        $link->save();

        return redirect('/links')->with('success', $link->short);
    }

    private function getRandomCode($length = 3)
    {
        $base = '0123456789abcdefghijklmnopqrstuvwxyz';
        $code = substr(str_shuffle($base), 0, $length);

        while(Link::where('short', $code)->count())
        {
            $code = substr(str_shuffle($base), 0, $length);
        }

        return $code;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Link $link)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        //
    }
}
