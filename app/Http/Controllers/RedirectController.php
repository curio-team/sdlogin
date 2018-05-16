<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link;

class RedirectController extends Controller
{
    public function go(Link $link)
    {
		return redirect($link->url);
    }
}
