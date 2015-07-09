<?php

/**
 * @file
 * Contains \Drupal\plug_example\FruitPluginManager.
 */

namespace Drupal\plug_example;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Plugin\Factory\ContainerFactory;
use Drupal\Core\Plugin\Discovery\YamlDiscovery;
use Drupal\plug\Util\Module;

/**
 * Name plugin manager.
 */
class FruitPluginManager extends DefaultPluginManager {

  /**
   * {@inheritdoc}
   */
  protected $defaults = array(
    // Human readable label for the fruit.
    'label' => '',
    // The amount of sugar in the fruit.
    'sugar' => '',
    // Is the fruit slimy?
    'slimy' => FALSE,
    // Default class for breakpoint implementations.
    'class' => 'Drupal\plug_example\Plugin\fruit\Fruit',
    // The plugin id. Set by the plugin system based on the top-level YAML key.
    'id' => '',
  );

  /**
   * Constructs FruitPluginManager.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \DrupalCacheInterface $cache_backend
   *   Cache backend instance to use.
   */
  public function __construct(\Traversable $namespaces, \DrupalCacheInterface $cache_backend) {
    parent::__construct(FALSE, $namespaces);
    $this->discovery = new YamlDiscovery('fruits', Module::getDirectories());
    $this->factory = new ContainerFactory($this);
    $this->alterInfo('fruit_plugin');
    $this->setCacheBackend($cache_backend, 'fruit_plugins');
  }

  /**
   * FruitPluginManager factory method.
   *
   * @param string $bin
   *   The cache bin for the plugin manager.
   *
   * @return FruitPluginManager
   *   The created manager.
   */
  public static function create($bin = 'cache') {
    return new static(Module::getNamespaces(), _cache_get_object($bin));
  }

}
