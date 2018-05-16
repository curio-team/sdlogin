<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserApiController extends Controller
{
    public function me()
    {
        return User::where('id', Auth::user()->id)->with('groups')->get();
    }
}
