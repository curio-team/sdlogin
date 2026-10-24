<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Carbon\Carbon;

class GroupLoginController extends Controller
{
    public function index()
    {
        $groups = Group::getQuery(Carbon::now(), false, true, false, ['name', 'asc'])
            ->where('type', 'class')
            ->get();

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
        $userprint = [];

        /**
         * @var \App\Models\User $user
         */
        foreach ($group->users as $user) {
            // random_int is cryptographically secure, unlike str_shuffle
            $pass = '';
            for ($i = 0; $i < 6; $i++) {
                $pass .= $data[random_int(0, strlen($data) - 1)];
            }

            $user->password = bcrypt($pass);
            // These passwords are printed and handed out, so they must be replaced on first login
            $user->password_force_change = now();
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
