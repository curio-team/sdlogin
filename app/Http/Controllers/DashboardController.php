<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\User;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user()->with('groups', 'groupHistory')->first();
        $name = explode(' ', $user->name);

        return view('home')
            ->with('user', $user)
            ->with('firstname', $name[0]);
    }
}
