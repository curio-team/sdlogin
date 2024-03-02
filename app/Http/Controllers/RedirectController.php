<?php

namespace App\Http\Controllers;

use App\Models\Link;

class RedirectController extends Controller
{
    public function go(Link $link)
    {
        return redirect($link->url);
    }
}
