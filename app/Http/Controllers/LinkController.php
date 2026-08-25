<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('links.index')->with('links', Link::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Restricted to the QR "alphanumeric mode" character set (digits,
            // uppercase letters and hyphen) so short links always produce the
            // smallest possible QR code.
            'short' => 'nullable|regex:/^[A-Za-z0-9-]+$/',
            'url' => 'required|url',
            'title' => 'nullable'
        ]);

        $short = $request->short ? strtoupper($request->short) : null;

        if ($short != null && Link::whereRaw('LOWER(short) = ?', [strtolower($short)])->count()) {
            return back()->withErrors('Korte link moet uniek zijn!');
        }

        $link = new Link();
        $link->short = $short ?? $this->getRandomCode();
        $link->url = $request->url;
        $link->on_frontpage = $request->has('on_frontpage');
        $link->title = $request->title;
        $link->creator = FacadesAuth::user()->id;

        $link->save();

        return redirect('/links')->with('success', $link->short);
    }

    private function getRandomCode($length = 3)
    {
        $base = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($base), 0, $length);

        while (Link::whereRaw('LOWER(short) = ?', [strtolower($code)])->count()) {
            $code = substr(str_shuffle($base), 0, $length);
        }

        return $code;
    }

    public function edit(Link $link)
    {
        return view('links.edit')->with('link', $link);
    }

    public function update(Request $request, Link $link)
    {
        $request->validate([
            'title' => 'nullable',
            'url' => 'required|url'
        ]);

        $link->on_frontpage = $request->has('on_frontpage');
        $link->title = $request->title;
        $link->url = $request->url;
        $link->save();

        return redirect('/links')->with('updated', $link->short);
    }

    /**
     * Generate a QR code for the given link's short URL.
     */
    public function qr(Link $link, Request $request)
    {
        // Uppercased so the QR encoder can use the compact alphanumeric
        // mode for the whole URL (scheme, host and short code are all
        // case-insensitive to resolve).
        $data = strtoupper($link->shortUrl());

        $result = (new Builder(
            writer: new SvgWriter(),
            data: $data,
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
            size: 300,
            margin: 10,
        ))->build();

        $response = response($result->getString(), 200)
            ->header('Content-Type', $result->getMimeType());

        if ($request->boolean('download')) {
            $response->header('Content-Disposition', 'attachment; filename="' . $link->short . '-qr.svg"');
        }

        return $response;
    }

    public function delete(Link $short)
    {
        return view('links.delete')->with('link', $short);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if (!is_array($request->delete)) {
            return redirect()->back();
        }

        foreach ($request->delete as $id) {
            $link = Link::find($id);
            $link->delete();
        }

        return redirect('/links');
    }
}
