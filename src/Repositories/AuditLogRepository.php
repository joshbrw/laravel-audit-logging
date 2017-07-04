<?php

namespace Joshbrw\AuditLogging\Repositories;

use Illuminate\Support\Collection;
use Joshbrw\AuditLogging\Entities\AuditLog;

interface AuditLogRepository
{
    /**
     * Get all Audit Logs for an entity.
     * @param mixed $entity
     * @return Collection|AuditLog[]
     */
    public function getAllAuditLogs($entity): Collection;
}
