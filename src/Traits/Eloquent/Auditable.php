<?php

namespace Joshbrw\AuditLogging\Traits\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Joshbrw\AuditLogging\Entities\AuditLog;

/**
 * @var Model $this
 */
trait Auditable
{

    /**
     * @return MorphMany
     */
    public function auditLogItems(): MorphMany
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }
}
