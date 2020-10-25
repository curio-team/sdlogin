<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Group;

class UserCleanupController extends Controller
{
    public function show()
    {
        $users = User::whereDoesntHave('groups', function ($query) {
            $query->whereDate('date_start', '<', Carbon::now());
            $query->whereDate('date_end', '>=', Carbon::now());
        })
        ->where('type', 'student')
        ->orderBy('created_at', 'desc')
        ->orderBy('name', 'asc')
        ->get();

        return view('users.cleanup')->with(compact('users'));
    }

    public function clean(Request $request)
    {
        if(!is_array($request->delete))
        {
            return redirect()->back();
        }

        foreach($request->delete as $id)
        {
            $user = optional(User::find($id));
            $user->groups()->detach();
            $user->delete();
        }

        return redirect('/users')->with('notice', 'Gebruikers opgeruimd!');
    }
}
