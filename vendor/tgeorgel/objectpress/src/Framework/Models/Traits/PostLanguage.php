<?php

namespace OP\Framework\Models\Traits;

use OP\Framework\Factories\ModelFactory;
use OP\Framework\Helpers\LanguageHelper;

/**
 * @package  ObjectPress
 * @author   tgeorgel
 * @version  1.0.5
 * @access   public
 * @since    1.0.0
 */
trait PostLanguage
{
    /**
     * Get post current language
     *
     * @return string
     * @since 1.0.0
     */
    public function lang()
    {
        return $this->getLang();
    }


    /**
     * Get post current language
     *
     * @return string Lang slug (eg: 'en')
     * @since 1.0.0
     */
    public function getLang()
    {
        return LanguageHelper::getPostLang($this->id);
    }

    
    /**
     * Set post current language
     *
     * @param string $lang Set the post lang from it's slug (eg: 'en' or 'fr')
     *
     * @return self
     * @chainable
     * @since 1.0.0
     */
    public function setLang(string $lang)
    {
        LanguageHelper::setPostLang($this->id, $lang);
        return $this;
    }


    /**
     * Get post current language
     *
     * @param string $language_slug Lang slug (eg: 'en')
     *
     * @return static
     * @since 1.0.0
     */
    public function getTranslation(string $language_slug)
    {
        $translation = LanguageHelper::getPostIn($this->id, $language_slug);

        if (!$translation || !is_int($translation)) {
            return false;
        }

        return static::find($translation);
    }

    
    /**
     * Get post all translations.
     *
     * @return array
     * @since 1.0.4
     */
    public function getTranslations()
    {
        $translations = LanguageHelper::getPostTranslations($this->id);

        return ModelFactory::posts($translations);
    }
}
