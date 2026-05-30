<?php

namespace App\Http\Controllers\Auth;

/**
 * @mixin \App\Http\Controllers\Auth\LoginController
 * @property string $redirectTo     Exists in LoginController
 */
trait RedirectsUsers
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        return $this->redirectTo;
    }
}
