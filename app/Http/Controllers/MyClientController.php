<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use \Laravel\Passport\Client;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class MyClientController extends Controller
{


    private $clients;
    private $clientController;

    public function __construct(\Laravel\Passport\ClientRepository $clients,
                                \Illuminate\Contracts\Validation\Factory $validation)
    {
        $this->clients = $clients;
        $this->clientController = new \Laravel\Passport\Http\Controllers\ClientController($clients, $validation);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   

        $clients = Client::where('revoked', 0)->get();
        return view('clients.index')
            ->with('clients', $clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create')
            ->with('user', Auth::user());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|string',
            'redirect' => 'required|url'
        ]);

        $client = $this->clientController->store($request);
        return redirect('/clients/' . $client->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = $this->clients->find($id)->makeVisible('secret');
        return view('clients.show')
            ->with('client', $client);
    }

    public function delete($id)
    {
        $client = $this->clients->find($id);
        return view('clients.delete')
            ->with('client', $client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = $this->clients->find($id);
        $client->delete();

        return redirect('/clients');
    }
}
