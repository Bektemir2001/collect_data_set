<?php

namespace App\Services;

use Exception;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateService
{
    const LANGUAGES = [
        'KG' => 'ky',
        'RU' => 'ru',
        'EN' => 'en'
    ];

    public function translate($text, $source_lang, $target_lang): array
    {
        try
        {
            $translator = new GoogleTranslate();
            $translator->setSource(self::LANGUAGES[$source_lang]);
            $translator->setTarget(self::LANGUAGES[$target_lang]);

            return ['result' => $translator->translate($text), 'code' => 200];
        }
        catch (Exception $e)
        {
            return ['result' => $e->getMessage(), 'code' => 500];
        }

    }
}
