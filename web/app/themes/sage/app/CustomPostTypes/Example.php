<?php

namespace App\CustomPostTypes;

use OP\Framework\Boilerplates\CustomPostType;

/**
 * ⚠️ Activate Taxonomies in THEME_PATH . /config/app.php
 *    Read documentation: http://docs.objectpress.hydrat.agency/#/custom-post-types
 */
class Example extends CustomPostType
{
    /**
     * Custom post type identifier
     *
     * @var string
     */
    public static $cpt = 'example';

    /**
     * Singular and plural names of CPT
     *
     * @var string
     */
    public static $singular = 'Example';
    public static $plural   = 'Examples';

    /**
     * Menu icon to display in back-office (dash-icon)
     *
     * @var string
     * @since 1.3
     */
    public static $menu_icon = 'dashicons-hammer';

    /**
     * Override default CPT args
     *
     * @var array
     */
    public static $args_override = [
        'rewrite'    => [
            'slug' => 'example',
        ],
        'has_archive' => false,
        'supports'  => ['title', 'thumbnail']
    ];
}
