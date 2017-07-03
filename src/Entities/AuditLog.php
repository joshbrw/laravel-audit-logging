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

    /**
     * @return MorphTo
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
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
