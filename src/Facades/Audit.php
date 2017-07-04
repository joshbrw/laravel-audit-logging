<?php

namespace Joshbrw\AuditLogging\Facades;

use Illuminate\Support\Facades\Facade;
use Joshbrw\AuditLogging\Services\AuditLogManager;

class Audit extends Facade
{

    /**
     * Get the bound abstract
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return AuditLogManager::class;
    }
}
