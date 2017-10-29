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
		return Group::get(true, true, false, array('date_end', 'desc'), false, $grouped);
	}

	public static function getWithFuture($grouped = false)
	{
		return Group::get(false, true, true, array('date_end', 'desc'), true, $grouped);
	}

	public static function getAll()
	{
		return Group::where('type', 'class')
				->orderBy('date_start')
				->get();
	}

	public static function findOnlyCurrent($name, $date = false)
	{
		if(!$date)
		{
			$date = Carbon::now();
		}
		
		return Group::where('date_start', '<=', $date)
					->where('date_end', '>=', $date)
					->where('name', $name)
					->first();
	}

	public static function get($withHistory = false, $withCurrent = true, $withFuture = false, $orderBy = array('date_end', 'desc'), $futureNames = false, $grouped = false)
	{
		
		$klassen = Group::where('type', 'class')->orderBy($orderBy[0], $orderBy[1]);
		$overige = Group::where('type', '!=', 'class')->orderBy($orderBy[0], $orderBy[1]);
		$now = Carbon::now();

		if($withHistory)
		{
			if(!$withCurrent)
			{
				//only history, no current, no future
				$klassen = $klassen->whereDate('date_end', '<', $now);
				$overige = $overige->whereDate('date_end', '<', $now);
			}
			elseif($withCurrent && !$withFuture)
			{
				//history and current, no future
				$klassen = $klassen->whereDate('date_start', '<=', $now);
				$overige = $overige->whereDate('date_start', '<=', $now);
			}
		}
		else
		{
			if($withCurrent && !$withFuture)
			{
				//only current, no history or future
				$klassen = $klassen->whereDate('date_start', '<=', $now);
				$klassen = $klassen->whereDate('date_end', '>=', $now);
				
				$overige = $overige->whereDate('date_start', '<=', $now);
				$overige = $overige->whereDate('date_end', '>=', $now);
			}
			elseif(!$withCurrent && $withFuture) {
				//only future, no current or history
				$klassen = $klassen->whereDate('date_start', '>', $now);
				$overige = $overige->whereDate('date_start', '>', $now);
			}
			else{
				//current and future, no history
				$klassen = $klassen->whereDate('date_end', '>=', $now);
				$overige = $overige->whereDate('date_end', '>=', $now);
			}
		}

		$klassen = $klassen->get();
		$overige = $overige->get();

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
