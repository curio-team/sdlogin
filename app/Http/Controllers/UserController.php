<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\User;
use App\Group;
use Carbon\Carbon;

class UserController extends Controller
{

    use Auth\ChecksPasswords;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with('groups');
        $search = request('q', false);

        if($search)
        {
            $users = $users->whereHas('groups', function ($query){
                $search = request('q');
                $query->where('name', 'LIKE', "%$search%");
            });

            $users = $users->orWhere('id', 'LIKE', "%$search%");
            $users = $users->orWhere('name', 'LIKE', "%$search%");
        }
        
        $users = $users->paginate(request('n', 10));
        return view('users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create')
            ->with('groups', Group::getWithFuture(true));
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
            'type' => 'required|in:teacher,student',
            'id' => 'required|alpha_num',
            'name' => 'required|string',
            'email' => 'nullable|email',
            'password' => 'required|confirmed'
        ]);

        $user = new User();
        $user->id = $request->id;
        $user->name = $request->name;
        $user->type = $request->type;

        $user->email = $request->email;
        if($user->email == null)
        {
            $user->email = $user->id . '@' . ($user->type == 'student' ? 'edu.' : '') . 'rocwb.nl';
        }

        $check = $this->check_password($request->password, $user);
        if(!$check->passes)
        {
            return redirect()->back()->withInput($request->input())->withErrors(['msg' => 'Je nieuwe wachtwoord is niet sterk genoeg.', 'msg2' =>  'Dit wachtwoord zou in ongeveer ' . $check->time . ' te kraken zijn!']);
        }
        
        $user->password = bcrypt($request->password);
        $user->save();

        if($request->groups != null)
        {
            $user->groups()->attach($request->groups);
        }
        
        return redirect('/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user_groups = $user->groupsWithFuture();
        return view('users.edit')
            ->with('groups', Group::getWithFuture(true))
            ->with('user_groups', $user_groups->get()) 
            ->with('user_group_ids', $user_groups->pluck('id'))
            ->with('user_groups_history', $user->groupHistory()->get())
            ->with('user', $user);
    }

    public function profile(User $user)
    {
        if (Gate::denies('edit-self', $user)) { return redirect('/me'); }

        return view('users.profile')
            ->with('user_groups', $user->groupsWithFuture()->get()) 
            ->with('user_groups_history', $user->groupHistory()->get())
            ->with('user', $user);
    }

    public function profile_update(Request $request, User $user)
    {
        if (Gate::denies('edit-self', $user)) { return redirect('/me'); }

        if(!password_verify($request->password, $user->getPassword()))
        {
             return redirect()->back()->withErrors(['msg' => 'Je huidige wachtwoord is niet correct.']);
        }

        $request->validate([
            'password_new' => 'nullable|confirmed'
        ]);

        $check = $this->check_password($request->password_new, $user);
        if(!$check->passes)
        {
            return redirect()->back()->withErrors(['msg' => 'Je nieuwe wachtwoord is niet sterk genoeg.', 'msg2' =>  'Dit wachtwoord zou in ongeveer ' . $check->time . ' te kraken zijn!']);
        }

        $user->password = bcrypt($request->password_new);
        $user->save();
        $request->session()->flash('notice', array(
            'Je wachtwoord is opgeslagen.',
            'Je hebt een ' . ($check->score == 3 ? 'redelijk' : 'heel') . ' sterk wachtwoord gekozen.',
            'Het zou ongeveer ' . $check->time . ' duren om dit wachtwoord te kraken!'
        ));

        return redirect('/users/' . $user->id . '/profile');
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'password' => 'nullable|confirmed'
        ]);

        if($request->password != null)
        {
            $check = $this->check_password($request->password, $user);
            if(!$check->passes)
            {
                return redirect()->back()->withInput($request->input())->withErrors(['msg' => 'Je nieuwe wachtwoord is niet sterk genoeg.', 'msg2' =>  'Dit wachtwoord zou in ongeveer ' . $check->time . ' te kraken zijn!']);
            }
            $user->password = bcrypt($request->password);
            $user->save();
        }

        $groups = request('groups', array());
        $groupsTotal = array_merge($groups, $user->groupHistory->pluck('id')->toArray());
        $user->groups()->sync($groupsTotal);

        return redirect('/users');
    }

    public function delete(User $user)
    {
        return view('users.delete')
            ->with('user', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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
            $user = User::find($id);
            $user->groups()->detach();
            $user->delete();
        }

        return redirect('/users');
    }
}
