<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Group;

class GroupApiController extends Controller
{
    public function group(Request $request, Group $group)
    {
    	if($request->user()->type == 'teacher') $group->load('users');
    	return $group;
    }

    public function find(Request $request, $name)
    {
        $group = Group::findOnlyCurrent($name);

        if($group == null) abort(404, 'Groep niet gevonden');
        if($request->user()->type == 'teacher') $group->load('users');

        return $group; 
    }
}
