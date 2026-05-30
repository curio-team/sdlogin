<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    /** @return Collection<int, Group> */
    public static function getWithHistory(): Collection
    {
        return Group::get(true, true, false, ['date_end', 'desc'], false);
    }

    /** @return Collection<int, Group> */
    public static function getWithFuture(): Collection
    {
        return Group::get(false, true, true, ['date_end', 'desc'], true);
    }

    /** @return Collection<int, Group> */
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
     * @param array{0: string, 1: string} $orderBy
     * @return Collection<int, Group>
     */
    public static function get(bool $withHistory = false, bool $withCurrent = true, bool $withFuture = false, array $orderBy = ['date_end', 'desc'], bool $futureNames = false): Collection
    {
        $query = Group::orderBy($orderBy[0], $orderBy[1]);
        $now = Carbon::now();

        if ($withHistory) {
            if (!$withCurrent) {
                $query = $query->whereDate('date_end', '<', $now);
            } elseif (!$withFuture) {
                $query = $query->whereDate('date_start', '<=', $now);
            }
        } else {
            if ($withCurrent && !$withFuture) {
                $query = $query->whereDate('date_start', '<=', $now)
                               ->whereDate('date_end', '>=', $now);
            } elseif (!$withCurrent && $withFuture) {
                $query = $query->whereDate('date_start', '>', $now);
            } else {
                $query = $query->whereDate('date_end', '>=', $now);
            }
        }

        $groups = $query->get();

        if ($withFuture && $futureNames) {
            foreach ($groups as $group) {
                if ($group->date_start > $now) {
                    $group->name = $group->name . ' (vanaf ' . $group->date_start . ')';
                }
            }
        }

        return $groups;
    }
}
