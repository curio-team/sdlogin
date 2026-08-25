<?php

namespace App\Http\Controllers;

use App\Models\Link;

class RedirectController extends Controller
{
    public function go(Link $link)
    {
        // Stored server-side, not passed through from the current request; validated
        // with the `url` rule on creation/update (see LinkController).
        /** @psalm-taint-escape header */
        $url = strval($link->url);

        return redirect($url);
    }
}
