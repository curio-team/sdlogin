<?php

namespace App\Models;

use Laravel\Passport\Client as PassportClient;
use OwenIt\Auditing\Auditable as AuditingTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Client extends PassportClient implements Auditable
{
    use AuditingTrait;

    protected array $auditExclude = [
        'secret',
    ];
}
