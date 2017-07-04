<?php

namespace Joshbrw\AuditLogging\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Joshbrw\AuditLogging\Entities\AuditLog;
use Joshbrw\AuditLogging\Repositories\AuditLogRepository;
use Joshbrw\AuditLogging\Traits\Eloquent\Auditable;

class EloquentAuditLogRepository implements AuditLogRepository
{

    /**
     * Get all Audit Logs for an entity.
     * @param mixed $entity
     * @return Collection|AuditLog[]
     */
    public function getAllAuditLogs($entity): Collection
    {
        if (!$this->isAuditable($entity)) {
            return new Collection;
        }

        return $entity->auditLogItems()->orderBy('created_at', 'desc')->get();
    }

    /**
     * Is a certain Entity Auditable?
     * @param $entity
     * @return bool
     */
    private function isAuditable($entity): bool
    {
        if (!is_object($entity)) {
            return false;
        }

        if (!$entity instanceof Model) {
            return false;
        }

        $traits = class_uses($entity);

        return in_array(Auditable::class, $traits);
    }
}
