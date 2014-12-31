<?php

/**
 * @file
 * Contains \Drupal\Core\Plugin\DefaultPluginManager
 */

namespace Drupal\Core\Plugin;

use Drupal\Component\Plugin\Discovery\CachedDiscoveryInterface;
use Drupal\Component\Plugin\Discovery\DiscoveryCachedTrait;
use Drupal\Component\Plugin\PluginManagerBase;
use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Plugin\Discovery\AnnotatedClassDiscovery;
use Drupal\Core\Plugin\Factory\ContainerFactory;

/**
 * Base class for plugin managers.
 *
 * @ingroup plugin_api
 */
class DefaultPluginManager extends PluginManagerBase implements PluginManagerInterface, CachedDiscoveryInterface {

  use DiscoveryCachedTrait;

  /**
   * Cache backend instance.
   *
   * @var \DrupalCacheInterface
   */
  protected $cacheBackend;

  /**
   * The cache key.
   *
   * @var string
   */
  protected $cacheKey;

  /**
   * Name of the alter hook if one should be invoked.
   *
   * @var string
   */
  protected $alterHook;

  /**
   * The subdirectory within a namespace to look for plugins, or FALSE if the
   * plugins are in the top level of the namespace.
   *
   * @var string|bool
   */
  protected $subdir;

  /**
   * A set of defaults to be referenced by $this->processDefinition() if
   * additional processing of plugins is necessary or helpful for development
   * purposes.
   *
   * @var array
   */
  protected $defaults = array();

  /**
   * Creates the discovery object.
   *
   * @param string|bool $subdir
   *   The plugin's subdirectory, for example Plugin/views/filter.
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param string|null $plugin_interface
   *   (optional) The interface each plugin should implement.
   * @param string $plugin_definition_annotation_name
   *   (optional) The name of the annotation that contains the plugin definition.
   *   Defaults to 'Drupal\Component\Annotation\Plugin'.
   */
  public function __construct($subdir, \Traversable $namespaces, $plugin_interface = NULL, $plugin_definition_annotation_name = 'Drupal\Component\Annotation\Plugin') {
    $this->subdir = $subdir;
    $this->discovery = new AnnotatedClassDiscovery($subdir, $namespaces, $plugin_definition_annotation_name);
    $this->factory = new ContainerFactory($this, $plugin_interface);
  }

  /**
   * Initialize the cache backend.
   *
   * Plugin definitions are cached using the provided cache backend. The
   * interface language is added as a suffix to the cache key.
   *
   * @param \DrupalCacheInterface $cache_backend
   *   Cache backend instance to use.
   * @param string $cache_key
   *   Cache key prefix to use, the language code will be appended
   *   automatically.
   */
  public function setCacheBackend(\DrupalCacheInterface $cache_backend, $cache_key) {
    $this->cacheBackend = $cache_backend;
    $this->cacheKey = $cache_key;
  }

  /**
   * Initializes the alter hook.
   *
   * @param string $alter_hook
   *   Name of the alter hook; for example, to invoke
   *   hook_mymodule_data_alter() pass in "mymodule_data".
   */
  protected function alterInfo($alter_hook) {
    $this->alterHook = $alter_hook;
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinitions() {
    $definitions = $this->getCachedDefinitions();
    if (!isset($definitions)) {
      $definitions = $this->findDefinitions();
      $this->setCachedDefinitions($definitions);
    }
    return $definitions;
  }

  /**
   * {@inheritdoc}
   */
  public function clearCachedDefinitions() {
    if ($this->cacheBackend) {
      $this->cacheBackend->clear($this->cacheKey);
    }
    $this->definitions = NULL;
  }

  /**
   * Returns the cached plugin definitions of the decorated discovery class.
   *
   * @return array|null
   *   On success this will return an array of plugin definitions. On failure
   *   this should return NULL, indicating to other methods that this has not
   *   yet been defined. Success with no values should return as an empty array
   *   and would actually be returned by the getDefinitions() method.
   */
  protected function getCachedDefinitions() {
    if (!isset($this->definitions) && $this->cacheBackend && $cache = $this->cacheBackend->get($this->cacheKey)) {
      $this->definitions = $cache->data;
    }
    return $this->definitions;
  }

  /**
   * Sets a cache of plugin definitions for the decorated discovery class.
   *
   * @param array $definitions
   *   List of definitions to store in cache.
   */
  protected function setCachedDefinitions($definitions) {
    if ($this->cacheBackend) {
      $this->cacheBackend->set($this->cacheKey, $definitions, CACHE_PERMANENT);
    }
    $this->definitions = $definitions;
  }


  /**
   * Performs extra processing on plugin definitions.
   *
   * By default we add defaults for the type to the definition. If a type has
   * additional processing logic they can do that by replacing or extending the
   * method.
   */
  public function processDefinition(&$definition) {
    if (!empty($this->defaults) && is_array($this->defaults)) {
      $definition = drupal_array_merge_deep($this->defaults, $definition);
    }
  }

  /**
   * Finds plugin definitions.
   *
   * @return array
   *   List of definitions to store in cache.
   */
  protected function findDefinitions() {
    $definitions = $this->discovery->getDefinitions();
    foreach ($definitions as $plugin_id => &$definition) {
      $this->processDefinition($definition, $plugin_id);
    }
    if ($this->alterHook) {
      drupal_alter($this->alterHook, $definitions);
    }
    // If this plugin was provided by a module that does not exist, remove the
    // plugin definition.
    foreach ($definitions as $plugin_id => $plugin_definition) {
      // If the plugin definition is an object, attempt to convert it to an
      // array, if that is not possible, skip further processing.
      if (is_object($plugin_definition) && !($plugin_definition = (array) $plugin_definition)) {
        continue;
      }
      // TODO: Check if !in_array($plugin_definition['provider'], array('core', 'component')) is doing anything.
      if (isset($plugin_definition['provider']) && !in_array($plugin_definition['provider'], array('core', 'component')) && !module_exists($plugin_definition['provider'])) {
        unset($definitions[$plugin_id]);
      }
    }
    return $definitions;
  }

}
