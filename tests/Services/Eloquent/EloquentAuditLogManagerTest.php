<?php

namespace Joshbrw\AuditLogging\Tests\Services\Eloquent;

use Joshbrw\AuditLogging\Contracts\TranslationResolver;
use Joshbrw\AuditLogging\Contracts\UserResolver;
use Joshbrw\AuditLogging\Entities\AuditLog;
use Joshbrw\AuditLogging\Services\Eloquent\EloquentAuditLogManager;
use Joshbrw\AuditLogging\Tests\TestCase;

class EloquentAuditLogManagerTest extends TestCase
{

    /**
     * @var EloquentAuditLogManager
     */
    private $manager;

    protected function setUp()
    {
        $this->manager = new EloquentAuditLogManager;
    }

    /** @test */
    public function can_set_user_resolver()
    {
        $userResolver = new class implements UserResolver {
            public function resolveCurrentUser()
            {
                return new class {
                    public $first_name = 'John';
                    public $last_name = 'Doe';
                    public $email = 'john-doe@example.org';
                };
            }
        };

        $this->manager->setUserResolver($userResolver);

        $this->assertAttributeEquals($userResolver,'userResolver', $this->manager);
    }

    /** @test */
    public function can_set_translation_resolver()
    {
        $translationResolver = new class implements TranslationResolver {
            public function translate(string $key, array $replacements = [], string $lang = null): string
            {
                return $key;
            }
        };

        $this->manager->setTranslationResolver($translationResolver);

        $this->assertAttributeEquals($translationResolver, 'translationResolver', $this->manager);
    }

    /** @test */
    public function returns_empty_string_when_translating_with_no_translation_resolver()
    {
        $log = new AuditLog([
            'message_key' => 'Not used.',
        ]);

        $actual = $this->manager->translate($log);

        $this->assertSame('', $actual);
    }

    /** @test */
    public function uses_translation_resolver_to_translate_audit_log()
    {
        $log = new AuditLog([
            'message_key' => 'This is a message.'
        ]);

        $translationResolver = new class implements TranslationResolver {
            public function translate(string $key, array $replacements = [], string $lang = null): string
            {
                return $key;
            }
        };

        $this->manager->setTranslationResolver($translationResolver);

        $actual = $this->manager->translate($log);

        $this->assertSame('This is a message.', $actual);
    }
}
