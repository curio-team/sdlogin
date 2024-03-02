<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserApiController extends Controller
{
    public function me(Request $request)
    {
        return User::where('id', $request->user()->id)->with('groups')->first();
    }

    public function index(Request $request)
    {
        if($request->user()->type != 'teacher') {
            abort(403, 'Only for teachers');
        }

        return User::all();
    }

    public function user(Request $request, User $user)
    {
        if($request->user()->type != 'teacher') {
            abort(403, 'Only for teachers');
        }

        $user->load('groups');
        return $user;
    }
}
