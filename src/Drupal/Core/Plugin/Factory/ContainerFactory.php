<?php
/**
 * @file
 * Contains \Drupal\Core\Plugin\Factory\ContainerFactory.
 */

namespace Drupal\Core\Plugin\Factory;

use Drupal\Component\Plugin\Factory\DefaultFactory;

/**
 * Plugin factory which passes a container to a create method.
 */
class ContainerFactory extends DefaultFactory {

  /**
   * {@inheritdoc}
   */
  public function createInstance($plugin_id, array $configuration = array()) {
    $plugin_definition = $this->discovery->getDefinition($plugin_id);
    $plugin_class = static::getPluginClass($plugin_id, $plugin_definition, $this->interface);

    // Otherwise, create the plugin directly.
    return new $plugin_class($configuration, $plugin_id, $plugin_definition);
  }

}
