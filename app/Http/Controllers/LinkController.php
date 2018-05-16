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
            'url' => 'required|url',
            'on_frontpage' => 'required|boolean'
        ]);

        if($request->short != null && Link::where('short', $request->short)->count())
        {
            return back()->withErrors('Korte link moet uniek zijn!');
        }

        $link = new Link();
        $link->short = $request->short ?? $this->getRandomCode();
        $link->url = $request->url;
        $link->on_frontpage = $request->on_frontpage;
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

    public function delete(Link $link)
    {
        return view('links.delete')->with('link', $link);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {        
        if(!is_array($request->delete))
        {
            return redirect()->back();
        }

        foreach($request->delete as $id)
        {
            $link = Link::find($id);
            $link->delete();
        }

        return redirect('/links');
    }
}
