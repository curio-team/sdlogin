<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;
use App\Models\Link;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function show()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        $user->load('groups', 'groupHistory');
        $name = explode(' ', $user->name);
        $apps = Client::where('revoked', 0)->where('for_development', 0)->get();
        $links = Link::where('on_frontpage', true)->get();

        return view('home')
            ->with('user', $user)
            ->with('firstname', $name[0])
            ->with('apps', $apps)
            ->with('links', $links);
    }
}
