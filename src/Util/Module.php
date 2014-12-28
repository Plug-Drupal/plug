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
    $namespaces = array();
    foreach (static::getModuleDirectories() as $module => $path) {
      $namespaces['Drupal\\' . $module] = $path . '/src';
    }
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
    $directories = &drupal_static(__FUNCTION__);
    if (isset($directories)) {
      return $directories;
    }
    if ($cache = cache_get('module_directories')) {
      return $cache->data;
    }
    $directories = array();
    foreach (module_list() as $module) {
      $directories[$module] = drupal_get_path('module', $module);
    }
    cache_set('module_directories', $directories);
    return $directories;
  }

}
