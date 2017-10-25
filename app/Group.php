<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Group extends Model
{

	protected $dates = ['date_start', 'date_end'];
    
	public function users()
	{
		return $this->belongsToMany(User::class);
	}

	public static function getWithHistory($grouped = false)
	{
		return Group::get(true, false, false, $grouped);
	}

	public static function getWithFuture($grouped = false)
	{
		return Group::get(false, true, true, $grouped);
	}

	public static function getAll()
	{
		return Group::where('type', 'class')
				->orderBy('date_start')
				->get();
	}

	public static function findOnlyCurrent($name)
	{
		return Group::where('date_start', '<=', Carbon::now())
					->where('date_end', '>=', Carbon::now())
					->where('name', $name)
					->first();
	}

	private static function get($withHistory = false, $withFuture = false, $futureNames = true, $grouped = false)
	{
		if($withHistory && $withFuture)
		{
			$klassen = Group::where('type', 'class')
				->orderBy('date_start')
				->get();
        	$overige = Group::where('type', '!=', 'class')
        		->orderBy('date_start')
        		->get();
		}
		elseif($withHistory && !$withFuture)
		{
			$klassen = Group::where('type', 'class')
				->whereDate('date_start', '<=', Carbon::now())
				->orderBy('date_start')
				->get();
			$overige = Group::where('type', '!=', 'class')
				->whereDate('date_start', '<=', Carbon::now())
				->orderBy('date_start')
				->get();
		}
		elseif(!$withHistory && $withFuture)
		{
			$klassen = Group::where('type', 'class')
				->whereDate('date_end', '>=', Carbon::now())
				->orderBy('date_start')
				->get();
			$overige = Group::where('type', '!=', 'class')
				->whereDate('date_end', '>=', Carbon::now())
				->orderBy('date_start')
				->get();
		}

		if($withFuture && $futureNames)
		{
			foreach ($klassen as $k)
			{
				if($k->date_start > Carbon::now())
				{
					$k->name = $k->name . ' (vanaf ' . $k->date_start . ')';
				}
			}

			foreach ($overige as $o)
			{
				if($o->date_start > Carbon::now())
				{
					$o->name = $o->name . ' (vanaf ' . $o->date_start . ')';
				}
			}
		}

		if($grouped)
		{
			$groups['klassen'] = $klassen;
			$groups['overige'] = $overige;
		}
		else
		{
			$klassen->merge($overige);
			$groups = $klassen;
		}

		return $groups;
	}
}
