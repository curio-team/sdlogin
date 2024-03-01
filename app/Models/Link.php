<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    public function getRouteKeyName()
    {
        return 'short';
    }

    public function creator()
    {
        return User::find($this->creator);
    }
}
