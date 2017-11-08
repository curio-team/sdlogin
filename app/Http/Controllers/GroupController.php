<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\all
     */
    public function index(Request $request)
    {
        $history = $current = $future = false;
        switch ($request->f) {
            case 'all':
                $history = true;
                $current = true;
                $future = true;
                break;

            case 'history':
                $history = true;
                break;

            case 'future':
                $future = true;
                break;

            default:
                $current = true;
                break;
        }

        $groups = Group::get($history, $current, $future, array('name', 'asc'));
        return view('groups.index')
            ->with('groups', $groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:class,group',
            'date_start' => 'required|date_format:Y-m-d|before:date_end',
            'date_end' => 'required|date_format:Y-m-d'
        ]);

        $group = new Group;
        $group->name = $request->name;
        $group->type = $request->type;
        $group->date_start = $request->date_start;
        $group->date_end = $request->date_end;
        $group->save();

        return redirect('/groups');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('groups.edit')
            ->with('group', $group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:class,group',
            'date_start' => 'required|date_format:Y-m-d|before:date_end',
            'date_end' => 'required|date_format:Y-m-d'
        ]);

        $group->name = $request->name;
        $group->type = $request->type;
        $group->date_start = $request->date_start;
        $group->date_end = $request->date_end;
        $group->save();

        return redirect('/groups');
    }

    public function delete(Group $group)
    {
        return view('groups.delete')
            ->with('group', $group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(!is_array($request->delete))
        {
            return redirect()->back();
        }

        foreach($request->delete as $id)
        {
            $group = Group::find($id);
            $group->users()->detach();
            $group->delete();
        }

        return redirect('/groups');
    }
}
