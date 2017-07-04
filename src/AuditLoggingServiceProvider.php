<?php

namespace Joshbrw\AuditLogging;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Joshbrw\AuditLogging\Contracts\TranslationResolver;
use Joshbrw\AuditLogging\Services\AuditLogManager;
use Joshbrw\AuditLogging\Services\Eloquent\EloquentAuditLogManager;
use Joshbrw\AuditLogging\TranslationResolvers\LaravelTranslationResolver;
use Joshbrw\AuditLogging\UserResolvers\LaravelUserResolver;
use Joshbrw\AuditLogging\UserResolvers\SentinelUserResolver;

class AuditLoggingServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the Service Provider
     */
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        $this->app->singleton(AuditLogManager::class, EloquentAuditLogManager::class);
    }

    /**
     * Boot the Service Provider
     */
    public function boot(): void
    {
        $auditLogManager = $this->app->make(AuditLogManager::class);

        $this->handleUserResolverBinding($auditLogManager);
        $this->handleTranslationResolverBinding($auditLogManager);
    }

    /**
     * Binds the User Resolver into the Audit Logger.
     * Currently supports Sentinel and the in-built Laravel Auth.
     * @param AuditLogManager $auditLogManager
     */
    private function handleUserResolverBinding(AuditLogManager $auditLogManager): void
    {
        if (class_exists('Cartalyst\Sentinel')) {
            $auditLogManager->setUserResolver($this->app->make(SentinelUserResolver::class));
            return;
        }

        $auditLogManager->setUserResolver($this->app->make(LaravelUserResolver::class));
    }

    /**
     * Binds the default Laravel Translation Resolver into the Audit Logger.
     * @param AuditLogManager $auditLogManager
     */
    private function handleTranslationResolverBinding(AuditLogManager $auditLogManager): void
    {
        $auditLogManager->setTranslationResolver($this->app->make(LaravelTranslationResolver::class));
    }

}
