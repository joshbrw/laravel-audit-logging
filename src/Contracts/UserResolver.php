<?php

namespace Joshbrw\AuditLogging\Contracts;

interface UserResolver
{
    /**
     * Resolve the Current User instance
     * @return mixed|null
     */
    public function resolveCurrentUser();
}
