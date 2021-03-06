<?php

return [

    /*
    |--------------------------------------------------------------------------
    | App custom post types declaration
    |--------------------------------------------------------------------------
    |
    | Insert here you app/theme custom post types
    | Format : 'cpt-identifier' => 'Path\To\CustomPostType\Class'
    |
    */
    'cpts' => [
        'example' => 'App\CustomPostTypes\Example',
    ],


    /*
    |--------------------------------------------------------------------------
    | App taxonomies declaration
    |--------------------------------------------------------------------------
    |
    | Insert here you app/theme taxonomies
    | Format : 'taxonomy-identifier' => 'Path\To\Taxonomy\Class'
    |
    */
    'taxonomies' => [
        'example-taxonomy' => 'App\Taxonomies\ExampleTaxonomy',
    ],


    /*
    |--------------------------------------------------------------------------
    | App APIs declaration
    |--------------------------------------------------------------------------
    |
    | Insert here you app/theme api routes
    | Format : 'namespace/route' => 'Path\To\Api\Class'
    |
    */
    'apis' => [
        // 'city/all' => 'App\Api\City\All',
    ],


    /*
    |--------------------------------------------------------------------------
    | App User roles declaration
    |--------------------------------------------------------------------------
    |
    | Insert here your user roles
    | Format: 'identifier' => 'Path\To\User\Role\Class'
    |
    */
    'user-roles' => [],


    /*
    |--------------------------------------------------------------------------
    | App GraphQL types declaration
    |--------------------------------------------------------------------------
    |
    | Insert here your GraphQL Types
    | Format: 'TypeIdentifier' => 'Path\To\GQL\Type\Class'
    |
    */
    'gql-types' => [],


    /*
    |--------------------------------------------------------------------------
    | App GraphQL fields declaration
    |--------------------------------------------------------------------------
    |
    | Insert here your GraphQL Fields
    | Format: 'fieldIdentifier' => 'Path\To\GQL\Field\Class'
    |
    */
    'gql-fields' => [],
];
