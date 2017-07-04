<?php

namespace Joshbrw\AuditLogging;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Joshbrw\AuditLogging\Contracts\TranslationResolver;
use Joshbrw\AuditLogging\Repositories\AuditLogRepository;
use Joshbrw\AuditLogging\Repositories\Eloquent\EloquentAuditLogRepository;
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
        $this->app->singleton(AuditLogManager::class, EloquentAuditLogManager::class);
        $this->app->bind(AuditLogRepository::class, EloquentAuditLogRepository::class);
    }

    /**
     * Boot the Service Provider
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        $this->publishes([
            dirname(__DIR__) . '/config/audit-logging.php' => config_path('audit-logging.php')
        ]);

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
        if ($this->app->bound('sentinel')) {
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
