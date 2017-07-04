<?php


use Joshbrw\AuditLogging\Entities\AuditLog;
use Joshbrw\AuditLogging\Facades\Audit;
use Joshbrw\AuditLogging\Services\AuditLogManager;

if (!function_exists('audit')) {
    /**
     * Helper method for logging an audit entry.
     * @param mixed $entity The entity to create the log for
     * @param string $messageKey The key of the translatable message to use
     * @param array|null $messageReplacements Array of replacements for the message
     * @param array|null $data Any data to attribute to the audit log item
     * @return AuditLog Audit log instance
     */
    function audit($entity, string $messageKey, array $messageReplacements = null, array $data = null): AuditLog {
        return Audit::log($entity, $messageKey, $messageReplacements, $data);
    }
}

if (!function_exists('translate_audit')) {
    /**
     * Translate an Audit Log
     * @param AuditLog $auditLog
     * @param string|null $lang
     * @return string
     */
    function translate_audit(AuditLog $auditLog, string $lang = null): string {
        return Audit::translate($auditLog, $lang);
    }
}
