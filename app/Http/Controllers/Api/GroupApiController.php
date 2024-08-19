<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Group;

class GroupApiController extends Controller
{
    public function index()
    {
        return Group::get(true, true, false, array('name', 'asc'));
    }

    public function group(Request $request, Group $group)
    {
        if($request->user()->type == 'teacher') {
            $group->load('users');
        } else {
            $group['users'] = collect($group->users()->get()->map(function ($u) { return (object) ['id' => $u['id']]; }));
        }
        return $group;
    }

    public function find(Request $request, $name)
    {
        $group = Group::findOnlyCurrent($name);

        if($group == null) {
            abort(404, 'Groep niet gevonden');
        }
        if($request->user()->type == 'teacher') {
            $group->load('users');
        }

        return $group;
    }
}
