<?php

namespace OP\Core;

use OP\Core\Patterns\SingletonPattern;

/**
 * @package  ObjectPress
 * @author   tgeorgel
 * @version  1.0.5
 * @access   public
 * @since    1.0.1
 */
final class Config
{
    use SingletonPattern;

    private static $paths = [];

    
    /**
     * is not allowed to call from outside to prevent from creating multiple instances,
     * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
     *
     * @since 1.0.3
     */
    private function __construct()
    {
        $_theme = get_template_directory() . '/config';
        $_base  = __DIR__ . '/../../config/';

        $this->addPath([$_theme, $_base]);
    }


    /**
     * Get a single config item from it's full key path
     * Recursively look into arrays.
     *
     * eg, for : auth.encryption.name
     * Config/auth.php => ['encryption' => ['name' => 'abc]]  => returns 'abc'
     *
     * @param string $key
     *
     * @return string|null Returns null if the key is not found
     * @since 1.0.3
     * @version 1.0.5
     */
    public function get(string $key)
    {
        if (strpos($key, '.') === false) {
            return '';
        }

        $keys   = explode('.', $key);
        $domain = array_shift($keys);
        $items  = $this->getDomain($domain);

        if (!$items) {
            return null;
        }

        return $this->getItemRecursive($items, $keys);
    }



    /**
     * Recursively look into arrays to find an item.
     *
     * For exemple, given the array ['my', 'key'] as $keys
     * And the array ['my' => ['key' => true]] as $items
     * Returns true.
     *
     * @param array $items The config array.
     * @param array $keys  The keys array.
     *
     * @return mixed|null Returns null if the key is not found
     * @since 1.0.5
     */
    public function getItemRecursive(array $items, array $keys)
    {
        if (!empty($items) && !empty($keys) && array_key_exists($keys[0], $items)) {
            // Still has children to find.
            if (count($keys) > 1 && is_array($items[$keys[0]])) {
                $key = array_shift($keys);
                return $this->getItemRecursive($items[$key], $keys);
            }
            
            // No more keys to find, return result.
            if (count($keys) == 1) {
                return $items[$keys[0]];
            }
        }

        return null;
    }


    /**
     * Get a config Domain array from it's path
     *
     * @param string $domain
     *
     * @return array|false
     * @since 1.0.3
     */
    public function getDomain(string $domain)
    {
        $relative_path = $this->domainToRelPath($domain);
        $full_paths    = $this->relativeToFullPath($relative_path);
        
        if (empty($full_paths)) {
            return false;
        }

        $conf_arrays = $result = [];

        foreach ($full_paths as $full_path) {
            $conf_arrays[] = include $full_path;
        }
        
        foreach ($conf_arrays as $conf_array) {
            foreach ($conf_array as $key => $val) {
                if (!array_key_exists($key, $result)) {
                    $result[$key] = $val;
                    continue;
                }

                if (is_array($result[$key]) && is_array($val)) {
                    $result[$key] = $result[$key] + $val;
                }
                if (is_array($result[$key]) && (is_string($val))) {
                    $result[$key][] = $val;
                }
            }
        }

        return $result;
    }


    /**
     * Iterate into paths to find the first presence of $relative_path.
     * If the relative path can't be found on any paths, returns false
     *
     * @param string $relative_path
     *
     * @return array
     * @since 1.0.3
     */
    private function relativeToFullPath(string $relative_path)
    {
        $paths = [];

        foreach (static::$paths as $path) {
            $test_path = implode('', [$path, '/', $relative_path]);

            if (file_exists($test_path)) {
                $paths[] = $test_path;
            }
        }

        return $paths;
    }


    /**
     * From domain, get relative file path
     *
     * @param string $domain
     *
     * @return string
     * @since 1.0.3
     */
    private function domainToRelPath(string $domain): string
    {
        return implode('', [
            str_replace('.', '/', strtolower($domain)),
            '.php'
        ]);
    }


    /**
     * Add a path to search config files from.
     *
     * @param  string|array $paths
     *
     * @return void
     * @since 1.0.3
     */
    public function addPath($paths)
    {
        if (is_string($paths)) {
            $paths = [$paths];
        }

        if (!is_array($paths)) {
            throw new \Exception("OP : Error : Adding a path to config class must be a string or an array");
        }

        $paths = array_filter(array_map('realpath', $paths));

        array_unshift(static::$paths, ...$paths);
    }


    /**
     * Returns the paths to search config files from.
     *
     * @return array
     */
    public function getPaths(): array
    {
        return static::$paths;
    }
}