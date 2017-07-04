<?php

namespace Joshbrw\AuditLogging\Entities;

use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Joshbrw\AuditLogging\Services\AuditLogManager;

class AuditLog extends Model
{

    use UuidModelTrait;

    protected $table = 'audit_log';

    protected $fillable = [
        'auditable_type',
        'auditable_id',
        'message_key',
        'message_replacements',
        'data',
        'user_id',
    ];

    protected $casts = [
        'message_replacements' => 'array',
        'data' => 'array',
    ];

    /**
     * @return MorphTo
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relationship for the User
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        if (!$userModel = config('audit-logging.userModel')) {
            throw new \RuntimeException("The userModel config key couldn't be found.");
        }

        return $this->belongsTo($userModel, 'user_id', 'id');
    }

    /**
     * Get the translated message for this Audit Log
     * @param null $lang
     * @return string
     */
    public function getMessage($lang = null): string
    {
        return app(AuditLogManager::class)->translate($this, $lang);
    }
}
