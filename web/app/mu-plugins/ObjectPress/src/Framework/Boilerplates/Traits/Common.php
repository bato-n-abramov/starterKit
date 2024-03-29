<?php

namespace OP\Framework\Boilerplates\Traits;

use OP\Core\Locale;
use OP\Support\Facades\Config;

/**
 * @package  ObjectPress
 * @author   tgeorgel
 * @version  1.0.3
 * @access   public
 * @since    1.0.3
 */
trait Common
{
    /**
     * CPT/Taxonomy argument to overide over boilerplate
     *
     * @var array
     * @since 1.0.3
     */
    public static $args_override = [];


    /**
     * CPT/Taxonomy labels to overide over boilerplate
     *
     * @var array
     * @since 1.0.3
     */
    public static $labels_override = [];


    /**
     * Enable graphql on this CPT/Taxonomy
     *
     * @var bool
     * @since 1.0.0
     */
    public static $graphql_enabled = false;


    /**
     * i18n translation domain
     *
     * @var string
     * @since 1.0.0
     */
    protected static $i18n_domain = '';


    /**
     * i18n cpt default lang (format: 'en', 'fr'..).
     * Leave empty string to use the app default lang instead.
     * App default lang is defined by it's dedicated constant, default WPML/PolyLang lang, or wordpress locale.
     *
     * @var string
     * @since 1.0.3
     */
    protected static $i18n_base_lang = '';


    /**
     * Used to display male/female pronoun on concerned languages
     * Set true if should use female pronoun for this cpt
     *
     * @var bool
     * @since 1.0
     */
    public static $i18n_is_female = false;




    /********************************/
    /*                              */
    /*       Public Methods         */
    /*                              */
    /********************************/



    /**
     * Return the boilerplate wordpress identifier (cpt/taxo `name` on register)
     */
    public static function getIdentifier()
    {
        if (isset(static::$cpt)) {
            return static::$cpt;
        }

        if (isset(static::$taxonomy)) {
            return static::$taxonomy;
        }

        return '';
    }


    /**
     * Returns Taxonomy's domain for string translation
     *
     * @return string
     * @since 1.0.0
     */
    public static function getDomain()
    {
        $domain = static::$i18n_domain;

        if (Config::get('i18n.suffix_domains_current_lang') === true) {
            $domain .= '__' . (static::$i18n_base_lang ?: Locale::defaultLang());
        }

        return $domain;
    }


    /**
     * Convert CPT / Taxonomy names to graphql format.
     * eg: 'Étude de cas' => 'etudeDeCas'
     *
     * @param string
     * @return string
     *
     * @since 1.2
     */
    protected static function graphqlFormatName(string $type): string
    {
        return lcfirst(
            preg_replace(
                '/\s/',
                '',
                ucwords(
                    str_replace(
                        ['—', '-', '/', '\\'],
                        ' ',
                        sanitize_title($type)
                    )
                )
            )
        );
    }

    
    /**
     * The post type singular name, camel case.
     *
     * @return string
     */
    public static function getCamelizedSingular()
    {
        return static::graphqlFormatName(static::$singular);
    }


    /**
     * The post type plural name, camel case.
     *
     * @return string
     */
    public static function getCamelizedPlural()
    {
        return static::graphqlFormatName(static::$plural);
    }
}
