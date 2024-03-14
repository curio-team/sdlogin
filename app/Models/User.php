<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token, $this));
    }

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

    public function getPassword()
    {
        return $this->password;
    }
}
