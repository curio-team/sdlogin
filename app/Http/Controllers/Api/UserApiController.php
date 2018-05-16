<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserApiController extends Controller
{
    public function me(Request $request)
    {
        return User::where('id', $request->user()->id)->with('groups')->get();
    }

    public function user(Request $request, User $user)
    {
    	if($request->user()->type == 'teacher')
    	{
    		$user->load('groups');
    		return $user;
    	}
    	
    	abort(403, 'Only for teachers');
    }
}
