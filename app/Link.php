<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

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
