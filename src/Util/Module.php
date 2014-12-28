<?php

/**
 * @file
 * Contains Drupal\plug\Util\Module.
 */

namespace Drupal\plug\Util;

class Module {

  /**
   * Generates the cached array of available namespaces for plugins.
   *
   * @return \ArrayObject
   *   The generated array of namespaces.
   */
  public static function getNamespaces() {
    return new \ArrayObject(static::memoize('namespaces'));
  }

  /**
   * Generates the cached array of enabled module directories.
   *
   * @return array
   *   A list of module directories.
   */
  public static function getDirectories() {
    return static::memoize('directories');
  }

  /**
   * Memoize function to cache method results.
   *
   * @param string $method_name
   *   The method to execute name.
   *
   * @return array
   *   The function result
   */
  protected static function memoize($method_name) {
    $cache_name = 'module_' . drupal_strtolower($method_name);
    $data = &drupal_static($cache_name);
    if (isset($data)) {
      return $data;
    }
    if ($cache = cache_get($cache_name)) {
      return $cache->data;
    }
    $data = call_user_func_array(array(get_called_class(), $method_name), array());
    cache_set($cache_name, $data);
    return $data;
  }

  /**
   * Gets all the module directories.
   *
   * @return array
   *   A list of module directories.
   */
  protected static function directories() {
    $directories = array();
    foreach (module_list() as $module) {
      $directories[$module] = drupal_get_path('module', $module);
    }
    return $directories;
  }

  /**
   * Gets the array of available namespaces for plugins.
   *
   * @return array
   *   The generated array of namespaces.
   */
  protected static function namespaces() {
    $namespaces = array();
    foreach (static::getDirectories() as $module => $path) {
      $namespaces['Drupal\\' . $module] = $path . '/src';
    }
    return $namespaces;
  }

}
