<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    
	public function user()
	{
		return $this->hasOne(User::class, 'asset_id', 'id');
	}


}
