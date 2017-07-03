<?php

namespace Joshbrw\AuditLogging\Services\Eloquent;

use Joshbrw\AuditLogging\Contracts\TranslationResolver;
use Joshbrw\AuditLogging\Contracts\UserResolver;
use Joshbrw\AuditLogging\Entities\AuditLog;
use Joshbrw\AuditLogging\Services\AuditLogManager;

class EloquentAuditLogManager implements AuditLogManager
{

    /**
     * @var UserResolver|null
     */
    protected $userResolver;

    /**
     * @var TranslationResolver|null
     */
    protected $translationResolver;

    /**
     * Set the UserResolver
     * @param UserResolver $resolver
     * @return AuditLogManager
     */
    public function setUserResolver(UserResolver $resolver): AuditLogManager
    {
        $this->userResolver = $resolver;

        return $this;
    }

    /**
     * Set the TranslationResolver
     * @param TranslationResolver $resolver
     * @return AuditLogManager
     */
    public function setTranslationResolver(TranslationResolver $resolver): AuditLogManager
    {
        $this->translationResolver = $resolver;

        return $this;
    }

    /**
     * Create an Audit Log item for an Entity
     * @param mixed $entity The entity to create the log for
     * @param string $messageKey The key of the translatable message to use
     * @param array|null $messageReplacements Array of replacements for the message
     * @param array|null $data Any data to attribute to the audit log item
     * @return AuditLog Audit log instance
     */
    public function log($entity, string $messageKey, array $messageReplacements = null, array $data = null): AuditLog
    {
        $item = new AuditLog;
        $item->auditable_type = get_class($entity);
        $item->auditable_id = $entity->id;
        $item->message_key = $messageKey;
        $item->message_replacements = $messageReplacements ? json_encode($messageReplacements) : null;
        $item->data = $data ? json_encode($data) : null;

        if ($user = $this->getUser()) {
            $item->user_id = $user->id;
        }

        $item->save();

        return $item;
    }

    /**
     * Get the User to attribute to an Audit Log
     * @return mixed|null
     */
    protected function getUser()
    {
        if (!$this->userResolver instanceof UserResolver) {
            return null;
        }

        return $this->userResolver->resolveCurrentUser();
    }

    /**
     * Translate an Audit Log instance's message
     * @param AuditLog $auditLog
     * @param string|null $lang
     * @return string
     */
    public function translate(AuditLog $auditLog, string $lang = null): string
    {
        if (!$this->translationResolver instanceof TranslationResolver) {
            return '';
        }

        if ($auditLog->message_key === null) {
            return '';
        }

        return $this->translationResolver->translate(
            $auditLog->message_key,
            $auditLog->message_replacements ?: [],
            $lang
        );
    }
}
