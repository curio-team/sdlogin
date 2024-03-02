<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $casts = [
        'date_start' => 'datetime:Y-m-d',
        'date_end' => 'datetime:Y-m-d',
    ];

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
        if(!$date) {
            $date = Carbon::now();
        }

        return Group::where('date_start', '<=', $date)
                    ->where('date_end', '>=', $date)
                    ->where('name', $name)
                    ->first();
    }

    public static function get($withHistory = false, $withCurrent = true, $withFuture = false, $orderBy = array('date_end', 'desc'), $futureNames = false, $grouped = false)
    {
        $groepen = Group::orderBy($orderBy[0], $orderBy[1]);
        $now = Carbon::now();

        if($withHistory) {
            if(!$withCurrent) {
                //only history, no current, no future
                $groepen = $groepen->whereDate('date_end', '<', $now);
            } elseif($withCurrent && !$withFuture) {
                //history and current, no future
                $groepen = $groepen->whereDate('date_start', '<=', $now);
            }
        } else {
            if($withCurrent && !$withFuture) {
                //only current, no history or future
                $groepen = $groepen->whereDate('date_start', '<=', $now);
                $groepen = $groepen->whereDate('date_end', '>=', $now);
            } elseif(!$withCurrent && $withFuture) {
                //only future, no current or history
                $groepen = $groepen->whereDate('date_start', '>', $now);
            } else {
                //current and future, no history
                $groepen = $groepen->whereDate('date_end', '>=', $now);
            }
        }

        $groepen = $groepen->get();

        if($withFuture && $futureNames) {
            foreach ($groepen as $g) {
                if($g->date_start > $now) {
                    $g->name = $g->name . ' (vanaf ' . $g->date_start . ')';
                }
            }
        }

        if($grouped) {
            $groepen = $groepen->groupBy('type');
        }

        return $groepen;
    }
}
