<?php

/**
 * @file
 * Contains \Drupal\plugins_example\FoodPluginManager.
 */

namespace Drupal\plugins_example;

use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * SearchExecute plugin manager.
 */
class FoodPluginManager extends DefaultPluginManager {

  /**
   * Constructs FoodPluginManager
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \DrupalCacheInterface $cache_backend
   *   Cache backend instance to use.
   */
  public function __construct(\Traversable $namespaces, \DrupalCacheInterface $cache_backend) {
    parent::__construct('Plugin/Search', $namespaces, 'Drupal\search\Plugin\SearchInterface', 'Drupal\search\Annotation\SearchPlugin');
    $this->setCacheBackend($cache_backend, 'search_plugins');
    $this->alterInfo('search_plugin');
  }
}
