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

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('short', $value)
            ->orWhereRaw('LOWER(short) = ?', [strtolower($value)])
            ->first();
    }

    /**
     * The full short link URL (e.g. http://curio.codes/ABC).
     */
    public function shortUrl(): string
    {
        return 'http://curio.codes/' . $this->short;
    }

    public function creator(): mixed
    {
        return User::find($this->creator);
    }
}
