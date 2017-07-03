<?php

namespace Joshbrw\AuditLogging\UserResolvers;

use Illuminate\Contracts\Auth\Guard;
use Joshbrw\AuditLogging\Contracts\UserResolver;

class LaravelUserResolver implements UserResolver
{

    /**
     * @var Guard
     */
    private $guard;

    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Resolve the Current User instance
     * @return mixed|null
     */
    public function resolveCurrentUser()
    {
        return $this->guard->user();
    }
}
