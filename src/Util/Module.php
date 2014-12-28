<?php

/**
 * @file
 * Contains Drupal\plug\Util\Module.
 */

namespace Drupal\plug\Util;

class Module {

  /**
   * Generates the array of available namespaces for plugins.
   *
   * @return \ArrayObject
   *   The generated array of namespaces.
   */
  public static function getNamespaces() {
    $namespaces = &drupal_static(__FUNCTION__);
    if (isset($namespaces)) {
      return new \ArrayObject($namespaces);
    }
    if ($cache = cache_get('plugin_namespaces')) {
      $namespaces = $cache->data;
      return new \ArrayObject($namespaces);
    }
    $names = array();
    foreach (module_list() as $module) {
      $names['Drupal\\' . $module] = drupal_get_path('module', $module) . '/src';
    }
    $namespaces = $names;
    cache_set('plugin_namespaces', $namespaces);
    return new \ArrayObject($namespaces);
  }

  /**
   * Helper function to get all the module directories.
   *
   * @return array
   *   A list of module directories.
   */
  public static function getModuleDirectories() {
    $directories = array();
    foreach (module_list() as $module) {
      $directories[$module] = drupal_get_path('module', $module);
    }
    return $directories;
  }

}
