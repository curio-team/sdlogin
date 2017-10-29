<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class BatchGroupController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.batch');
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
            'date_start' => 'required|date_format:Y-m-d|before:date_end',
            'date_end' => 'required|date_format:Y-m-d'
        ]);

        $names = preg_split("/\\r\\n|\\r|\\n/", $request->names);
        $start = $request->date_start;
        $end = $request->date_end;

        foreach ($names as $name) {
            $group = new Group;
            $group->name = $name;
            $group->type = 'class';
            $group->date_start = $start;
            $group->date_end = $end;
            $group->save();
        }

        return redirect('/groups');
    }
}
