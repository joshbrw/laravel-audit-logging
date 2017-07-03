<?php


use Joshbrw\AuditLogging\Services\AuditLogManager;

if (!function_exists('audit')) {
    /**
     * Helper method for logging an audit entry.
     * @param mixed $entity Auditable entry
     * @param string $message The audit message
     * @param array|null $data Any data to associate with this audit item
     * @return mixed Audit log instance
     */
    function audit($entity, string $message, array $data = null) {
        return app(AuditLogManager::class)->log($entity, $message, $data);
    }
}
