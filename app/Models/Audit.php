<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use OwenIt\Auditing\Models\Audit as BaseAudit;

class Audit extends BaseAudit
{
    public function user(): MorphTo
    {
        // This is here to satisfy static analysis, which requires this method to have a strong return type, which
        // the actual implementation in the \OwenIt\Auditing\Audit trait does not have.
        return parent::user();
    }
}
