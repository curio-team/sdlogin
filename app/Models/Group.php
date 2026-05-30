<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
    ];

    protected $casts = [
        'date_start' => 'datetime:Y-m-d',
        'date_end' => 'datetime:Y-m-d',
    ];

    public function users(): BelongsToMany
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

    /**
     * @return Collection<int, Group>
     */
    public static function getAll(): Collection
    {
        return Group::where('type', 'class')
                ->orderBy('date_start')
                ->get();
    }

    public static function findOnlyCurrent(string $name, $date = false): ?Group
    {
        if (!$date) {
            $date = Carbon::now();
        }

        return Group::where('date_start', '<=', $date)
                    ->where('date_end', '>=', $date)
                    ->where('name', $name)
                    ->first();
    }

    /**
     * Returns groups optionally grouped by type, optionally with history and/or future groups, optionally with future group names.
     *
     * @param bool $withHistory Whether to include history groups (date_end < now)
     * @param bool $withCurrent Whether to include current groups (date_start <= now and date_end >= now)
     * @param bool $withFuture Whether to include future groups (date_start > now)
     * @param array $orderBy Array with column and direction to order by
     * @param bool $futureNames Whether to append the start date to future group names
     * @param bool $grouped Whether to group the result by type
     * @return Collection<int, Group>|Collection<string, Collection<int, Group>> Depending on $grouped, either a flat collection of groups or a collection of collections of groups grouped by type
     */
    public static function get($withHistory = false, $withCurrent = true, $withFuture = false, $orderBy = array('date_end', 'desc'), $futureNames = false, $grouped = false): Collection
    {
        $groepen = Group::orderBy($orderBy[0], $orderBy[1]);
        $now = Carbon::now();

        if ($withHistory) {
            if (!$withCurrent) {
                //only history, no current, no future
                $groepen = $groepen->whereDate('date_end', '<', $now);
            } elseif ($withCurrent && !$withFuture) {
                //history and current, no future
                $groepen = $groepen->whereDate('date_start', '<=', $now);
            }
        } else {
            if ($withCurrent && !$withFuture) {
                //only current, no history or future
                $groepen = $groepen->whereDate('date_start', '<=', $now);
                $groepen = $groepen->whereDate('date_end', '>=', $now);
            } elseif (!$withCurrent && $withFuture) {
                //only future, no current or history
                $groepen = $groepen->whereDate('date_start', '>', $now);
            } else {
                //current and future, no history
                $groepen = $groepen->whereDate('date_end', '>=', $now);
            }
        }

        $groepen = $groepen->get();

        if ($withFuture && $futureNames) {
            foreach ($groepen as $g) {
                if ($g->date_start > $now) {
                    $g->name = $g->name . ' (vanaf ' . $g->date_start . ')';
                }
            }
        }

        if ($grouped) {
            $groepen = $groepen->groupBy('type');
        }

        return $groepen;
    }
}
