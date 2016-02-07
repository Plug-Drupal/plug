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
   * @param bool $all
   *   Include values for disabled modules.
   *
   * @return \ArrayObject
   *   The generated array of namespaces.
   */
  public static function getNamespaces($all = FALSE) {
    if ($all) {
      // Do not use caches or cache the results.
      return new \ArrayObject(static::namespaces($all));
    }
    return new \ArrayObject(static::memoize('namespaces'));
  }

  /**
   * Generates the cached array of enabled module directories.
   *
   * @param bool $all
   *   Include values for disabled modules.
   *
   * @return array
   *   A list of module directories.
   */
  public static function getDirectories($all = FALSE) {
    if ($all) {
      // Do not use caches or cache the results.
      return static::directories($all);
    }
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
      $data = $cache->data;
      return $data;
    }
    $data = call_user_func_array(array(get_called_class(), $method_name), array());
    cache_set($cache_name, $data);
    return $data;
  }

  /**
   * Gets all the module directories.
   *
   * @param bool $all
   *   Include values for disabled modules.
   *
   * @return array
   *   A list of module directories.
   */
  protected static function directories($all = FALSE) {
    $directories = array();
    if ($all) {
      // We cannot use module_list to get the disabled modules. Query the system
      // table instead.
      $sql = "SELECT name FROM {system} WHERE type = :type";
      $modules = db_query($sql, array(':type' => 'module'))->fetchCol();
      $modules = drupal_map_assoc($modules);
    }
    else {
      $modules = module_list();
    }
    foreach ($modules as $module) {
      $directories[$module] = drupal_get_path('module', $module);
    }
    return $directories;
  }

  /**
   * Gets the array of available namespaces for plugins.
   *
   * @param bool $all
   *   Include values for disabled modules.
   *
   * @return array
   *   The generated array of namespaces.
   */
  protected static function namespaces($all = FALSE) {
    $namespaces = array();
    foreach (static::getDirectories($all) as $module => $path) {
      $namespaces['Drupal\\' . $module] = $path . '/src';
    }
    return $namespaces;
  }

}
