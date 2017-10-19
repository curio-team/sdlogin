<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function groups()
    {
        return $this->belongsToMany(Group::class)
            ->whereDate('date_start', '<', Carbon::now())
            ->whereDate('date_end', '>=', Carbon::now())
            ->orderBy('type')
            ->orderBy('date_start');
    }

    public function groupsWithFuture()
    {
        return $this->belongsToMany(Group::class)
            ->whereDate('date_end', '>=', Carbon::now())
            ->orderBy('type')
            ->orderBy('date_start');
    }

    public function groupHistory()
    {
        return $this->belongsToMany(Group::class)
            ->whereDate('date_end', '<', Carbon::now())
            ->orderBy('type')
            ->orderBy('date_start');
    }    

}
