<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Link extends Model implements Auditable
{
    use AuditingTrait;

    public function getRouteKeyName(): string
    {
        return 'short';
    }

    public function creator(): mixed
    {
        return User::find($this->creator);
    }
}
