<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Http\Rules\RedirectRule;

class ClientController extends Controller
{
    private $clients;

    private $clientController;

    public function __construct(
        ClientRepository $clients,
        ValidationFactory $validation,
        RedirectRule $redirectRule
    ) {
        $this->clients = $clients;
        $this->clientController = new \Laravel\Passport\Http\Controllers\ClientController($clients, $validation, $redirectRule);
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
            'redirect' => 'required|url',
            'for_development' => 'required|boolean'
        ]);

        $client = $this->clientController->store($request);
        $client->for_development = $request->for_development;
        $client->save();

        return redirect()->route('clients.show', $client);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = $this->clients->find($id)->makeVisible('secret');
        return view('clients.show')
            ->with('client', $client);
    }

    public function toggle_dev($id)
    {
        $client = $this->clients->find($id);
        $client->for_development = $client->for_development ? false : true;
        $client->save();
        return back();
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
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = $this->clients->find($id);
        $client->delete();

        return redirect('/clients');
    }
}
