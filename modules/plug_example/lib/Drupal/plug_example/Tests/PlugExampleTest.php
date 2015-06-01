<?php

/**
 * @file
 * Basic tests cases for plug_example module.
 */

namespace Drupal\plug_example\Tests;

use Drupal\plug_example\NamePluginManager;

class PlugExampleTest extends \DrupalWebTestCase {

  /**
   * The plugin manager.
   *
   * @var NamePluginManager
   */
  protected $manager;

  /**
   * Declare test information.
   *
   * @return array
   *   The information array.
   */
  public static function getInfo() {
    return array(
      'name' => 'Plug display name',
      'description' => 'Test the display name method functionality.',
      'group' => 'Plug',
    );
  }

  /**
   * Set up.
   */
  public function setUp() {
    parent::setUp();
    // Get a new Name plugin manager to instantiate the test plugins.
    $this->manager = NamePluginManager::create();
  }

  /**
   * Test if displayName() handles the names right.
   */
  function testDisplayName() {
    /** @var \Drupal\plug_example\Plugin\name\JohnTest $plugin */
    $plugin = $this->manager->createInstance('john_test', array('em' => TRUE));
    $this->assertEqual($plugin->displayName(), 'My name is: %name');
    $plugin = $this->manager->createInstance('john_test', array('em' => FALSE));
    $this->assertEqual($plugin->displayName(), 'My name is: @name');

    /** @var \Drupal\plug_example\Plugin\name\AcmeTest $plugin */
    $plugin = $this->manager->createInstance('acme_test', array('em' => TRUE));
    $this->assertEqual($plugin->displayName(), 'Company name: %name Inc.');
    $plugin = $this->manager->createInstance('acme_test', array('em' => FALSE));
    $this->assertEqual($plugin->displayName(), 'Company name: @name Inc.');
  }

  /**
   * Test plugin internals.
   */
  function testPluginInternals() {
    /** @var \Drupal\plug_example\Plugin\name\JohnTest $plugin */
    $plugin = $this->manager->createInstance('john_test', array('em' => TRUE));
    $definition = $plugin->getPluginDefinition();
    $expected = array(
      'class' => 'Drupal\plug_example\Plugin\name\JohnTest',
      'company' => FALSE,
      'id' => 'john_test',
      'provider' => 'plug_example',
    );
    $this->assertEqual($expected, $definition);
  }

}