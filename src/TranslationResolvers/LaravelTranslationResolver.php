<?php

namespace Joshbrw\AuditLogging\TranslationResolvers;

use Illuminate\Contracts\Translation\Translator;
use Joshbrw\AuditLogging\Contracts\TranslationResolver;

class LaravelTranslationResolver implements TranslationResolver
{

    /**
     * @var Translator
     */
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Translate a translation key, replacements and language
     * @param string $key
     * @param array $replacements
     * @param string|null $lang
     * @return string
     */
    public function translate(string $key, array $replacements = [], string $lang = null): string
    {
        return $this->translator->trans($key, $replacements, $lang);
    }
}
