<?php

namespace OP\Framework\Factories;

use Exception;
use OP\Framework\Helpers\PostHelper;

/**
 * @package  ObjectPress
 * @author   tgeorgel
 * @version  1.0.4
 * @access   public
 * @since    1.0.0
 */
class ModelFactory
{
    /**
     * Factory 'post' model, get the post type and initiate a corresponding Model if applicable.
     *
     * @param WP_post|int|string    $post_id   ID of the concerned post
     *
     * @return Model|null on failure
     * @version 1.0.3
     * @since 1.0.1
     */
    public static function post($post)
    {
        $post  = PostHelper::getPostFromUndefined($post);
        $model = null;

        if (!$post) {
            return null;
        }

        // Search for model in ICpts array
        if (
            interface_exists('\App\Interfaces\ICpts')
            && defined('\App\Interfaces\ICpts::MODELS')
            && is_array(\App\Interfaces\ICpts::MODELS)
            && array_key_exists($post->post_type, \App\Interfaces\ICpts::MODELS)
        ) {
            $supposed_model = \App\Interfaces\ICpts::MODELS[$post->post_type];

            if (class_exists($supposed_model)) {
                $model = $supposed_model;
            } else {
                throw new Exception(
                    "ObjectPress: The `$supposed_model` model does not exists for post type `$post->post_type`. Please checkup your MODELS binding in you ICpts Interface."
                );
            }
        } else {
            // Try to guess class model name (eg: 'custom-post-type' => 'App\Models\CustomPostType')
            $supposed_class_name = str_replace('-', '', ucwords($post->post_type, '-'));
            $full_supposed_class = "\App\Models\\$supposed_class_name";

            if (class_exists($full_supposed_class)) {
                $model = $full_supposed_class;
            }
        }

        if ($model) {
            return $model::find($post->ID);
        }

        return null;
    }


    /**
     * Call the model factory on the current post
     *
     * @return Model|null on failure
     * @version 1.0.4
     * @since 1.0.4
     */
    public static function currentPost()
    {
        $id = get_the_id();

        if (!$id) {
            global $post;
            $id = $post->ID ?? false;
        }

        if (!$id) {
            return null;
        }

        return static::post($id);
    }


    /**
     * Factory an array of 'post' model, get the post type and initiate a corresponding Model if applicable.
     *
     * @param array $posts WP_post|int|string of the concerned posts
     *
     * @return array
     * @version 1.0.4
     * @since 1.0.4
     */
    public static function posts(array $posts)
    {
        $results = [];

        foreach ($posts as $post) {
            $results[] = static::post($post);
        }
        
        return $results;
    }
}
