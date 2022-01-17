<?php
namespace App\Taxonomies;

use OP\Framework\Boilerplates\Taxonomy;

class ExampleTaxonomy extends Taxonomy
{
    /**
     * Taxonomy name
     *
     * @var string
     * @since 1.0.0
     */
    protected static $taxonomy = 'example-taxonomy';


    /**
     * Singular and plural names of Taxonomy
     *
     * @var string
     * @since 1.0.0
     */
    public static $singular = 'Example Taxonomy';
    public static $plural   = 'Example Taxonomies';


    /**
     * Register this taxonomy on thoses post types
     *
     * @var array
     * @since 1.0.0
     */
    protected static $post_types = [
        'example',
    ];


    /**
     * Activate 'single term' mode on this taxonomy
     *
     * @var bool
     * @since 1.0.3
     */
    public static $single_term = false;


    /**
     * 'single term' mode params 
     * 
     * @var array
     * @since 1.0.3
     */
    public static $single_term_params = [
        'default_term' => 'my-category',
    ];

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
    protected static $i18n_domain = 'theme-cpts';


    /**
     * i18n cpt default lang (format: 'en', 'fr'..).
     * Leave empty string to use the app default lang instead.
     * App default lang is defined by it's dedicated constant, default WPML/PolyLang lang, or wordpress locale.
     *
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
     * @since 1.0.3
     */
    public static $i18n_is_female = false;
}
