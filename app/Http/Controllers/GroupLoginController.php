<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class GroupLoginController extends Controller
{
    public function index()
    {
    	$groups = Group::get(false, true, false, array('name', 'asc'))->where('type', 'class');
    	return view('grouplogin.index')
    			->with(compact('groups'));
    }

    public function show(Group $group)
    {
    	return view('grouplogin.show')
    			->with(compact('group'));
    }

    public function do(Group $group)
    {
    	$data = '1234567890abcefghijklmnopqrstuvwxyz';
    	$userprint = array();
    	foreach($group->users as $user)
    	{
    		$pass = substr(str_shuffle($data), 0, 6);
    		$user->password = password_hash($pass, PASSWORD_DEFAULT);;
    		$user->save();

    		$userprint[] = [
    			"name" => trim($user->name),
    			"id"   => $user->id,
    			"pass" => $pass
    		];
    	}

    	return view('grouplogin.final')
    			->with(compact('userprint'))
    			->with(compact('group'));
    }
}
