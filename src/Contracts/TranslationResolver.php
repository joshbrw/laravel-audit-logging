<?php

namespace Joshbrw\AuditLogging\Contracts;

interface TranslationResolver
{

    /**
     * Translate a translation key, replacements and language
     * @param string $key
     * @param array $replacements
     * @param string|null $lang
     * @return string
     */
    public function translate(string $key, array $replacements = [], string $lang = null): string;
}
