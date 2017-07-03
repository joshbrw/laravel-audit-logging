# Laravel Audit Logging

A simple, easy-to-use audit logging system with translation at the heart. Uses UUIDs for easy dataset merging and management.

## Installation

1. Add `Joshbrw\AuditLogging\AuditLoggingServiceProviders` under the `providers` key in `config/app.php`.
2. Run `php artisan vendor:publish --provider=Joshbrw\AuditLogging\AuditLoggingServiceProvider` - this will publish the migration(s) to your top-level `database/migrations` directory.
3. Run `php artisan migrate` to run the migration(s) provided with this package.
4. On each of your Eloquent models that you wish to log, add the `Joshbrw\AuditLogging\Traits\Eloquent\Auditable` trait.

## Usage

### Basic Attributes

Every Audit Log item has two required attributes:

* `auditable_type` | `auditable_id` - The entity the audit relates to
* `message_key` - The translation key of the message

The option attributes are:

* `message_replacements` - An array of replacements that should be passed to the translator when displaying the audit log.
* `data` - Any array/object of data that you'd like to store against the Audit Log.
* `user_id` - The ID of the User performing the action being logged. **Supports Laravel's Auth and Sentinel by default, allows for custom adapters via the UserResolver** 

### Using the Helper Method & Service

This library ships with an `audit()` method, with the following syntax:

```php
    /**
     * Helper method for logging an audit entry.
     * @param mixed $entity The entity to create the log for
     * @param string $messageKey The key of the translatable message to use
     * @param array|null $messageReplacements Array of replacements for the message
     * @param array|null $data Any data to attribute to the audit log item
     * @return AuditLog Audit log instance
     */
    function audit($entity, string $messageKey, array $messageReplacements = null, array $data = null): AuditLog {
```

Which simply proxies through to the `Joshbrw\AuditLogging\AuditLogManager` service's `log()` method, which accepts the same parameters. 
