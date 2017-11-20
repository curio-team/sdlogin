<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\User;
use \Laravel\Passport\Client;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user()->load('groups', 'groupHistory');
        $name = explode(' ', $user->name);
        $apps = Client::where('revoked', 0);
        if($user->type == 'student')
        {
            $apps->where('for_development', 0);
        }
        $apps = $apps->get();

        return view('home')
            ->with('user', $user)
            ->with('firstname', $name[0])
            ->with('apps', $apps);
    }
}
