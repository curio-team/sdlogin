<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    public function getRouteKeyName(): string
    {
        return 'short';
    }

    public function creator(): mixed
    {
        return User::find($this->creator);
    }
}
