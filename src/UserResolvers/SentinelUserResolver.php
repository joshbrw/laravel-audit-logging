<?php

namespace Joshbrw\AuditLogging\UserResolvers;

use Joshbrw\AuditLogging\Contracts\UserResolver;

class SentinelUserResolver implements UserResolver
{

    /**
     * Resolve the Current User instance
     * @return mixed|null
     */
    public function resolveCurrentUser()
    {
        return app('sentinel')->getUser(true);
    }
}
