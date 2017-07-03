<?php

namespace Joshbrw\AuditLogging\Services;

use Joshbrw\AuditLogging\Contracts\TranslationResolver;
use Joshbrw\AuditLogging\Contracts\UserResolver;
use Joshbrw\AuditLogging\Entities\AuditLog;

interface AuditLogManager
{
    /**
     * Set the UserResolver
     * @param UserResolver $resolver
     * @return AuditLogManager
     */
    public function setUserResolver(UserResolver $resolver): AuditLogManager;

    /**
     * Set the TranslationResolver
     * @param TranslationResolver $resolver
     * @return AuditLogManager
     */
    public function setTranslationResolver(TranslationResolver $resolver): AuditLogManager;

    /**
     * Create an Audit Log item for an Entity
     * @param mixed $entity The entity to create the log for
     * @param string $messageKey The key of the translatable message to use
     * @param array|null $messageReplacements Array of replacements for the message
     * @param array|null $data Any data to attribute to the audit log item
     * @return AuditLog Audit log instance
     */
    public function log($entity, string $messageKey, array $messageReplacements = null, array $data = null): AuditLog;

    /**
     * Translate an Audit Log instance's message
     * @param AuditLog $auditLog
     * @param string|null $lang
     * @return string
     */
    public function translate(AuditLog $auditLog, string $lang = null): string;

}
