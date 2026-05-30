<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Auditable as AuditingTrait;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements OAuthenticatable, Auditable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use AuditingTrait;

    public $incrementing = false;

    protected array $auditExclude = [
        'password_force_change',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class)
            ->whereDate('date_start', '<', Carbon::now())
            ->whereDate('date_end', '>=', Carbon::now())
            ->orderBy('type')
            ->orderBy('date_start');
    }

    public function groupsWithFuture(): BelongsToMany
    {
        return $this->belongsToMany(Group::class)
            ->whereDate('date_end', '>=', Carbon::now())
            ->orderBy('type')
            ->orderBy('date_start');
    }

    public function groupHistory(): BelongsToMany
    {
        return $this->belongsToMany(Group::class)
            ->whereDate('date_end', '<', Carbon::now())
            ->orderBy('type')
            ->orderBy('date_start');
    }

    public function allGroups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    public function getPassword(): mixed
    {
        return $this->password;
    }

    public function isTeacher(): bool
    {
        return $this->type === 'teacher' || $this->type === 'admin';
    }

    public function isAdmin(): bool
    {
        return $this->type === 'admin';
    }
}
