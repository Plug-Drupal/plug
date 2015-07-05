<?php

/**
 * @file
 * Basic tests cases for plug_example module.
 */

namespace Drupal\plug_example\Tests;

use Drupal\plug_example\NamePluginManager;

class BasicTest extends BaseTest {

  /**
   * Expected output for default name plugins.
   *
   * @var array
   */
  protected $namePlugins = array(
    // Check that John is not a company, modified in hook_name_plugin_alter().
    'My name is: John Doe',
    'My name is: John Doe',
    'My name is: Mom',
    'Company name: Acme Inc.',
    'Company name: Acme Inc.',
  );

  /**
   * Cache id defined for name plugins.
   *
   * @var string
   */
  protected $nameCache = 'name_plugins';

  /**
   * Expected output for default fruit plugins.
   *
   * @var array
   */
  protected $fruitPlugins = array(
    // Check that Banana is in, added in hook_fruit_plugin_alter().
    'Fruit name: Banana',
    'Fruit name: Apple',
    'Fruit name: Orange',
    'Fruit name: Melon',
    'Yikes, Mamoncillo!',
  );

  /**
   * Cache id defined for name plugins.
   *
   * @var string
   */
  protected $fruitCache = 'fruit_plugins';

  /**
   * Annotated plugins test page path.
   *
   * @var string
   */
  protected $annotatedTestPath = 'plug/test/annotated';

  /**
   * YAML plugins test page path.
   *
   * @var string
   */
  protected $yamlTestPath = 'plug/test/yaml';

  /**
   * The plugin manager.
   *
   * @var NamePluginManager
   */
  protected $manager;

  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => 'Plug Example tests',
      'description' => 'Plug example basic tests',
      'group' => 'Plug',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp('registry_autoload', 'plug_example');
    // Get a new Name plugin manager to instantiate the test plugins.
    $this->manager = NamePluginManager::create();
  }

  /**
   * Tests annotated plugins example page output.
   */
  public function testBasicAnnotationExamplePage() {
    $this->assertExamplePageResults($this->namePlugins, $this->annotatedTestPath);
  }

  /**
   * Tests YAML plugins example page output.
   */
  public function testBasicYamlExamplePage() {
    $this->assertExamplePageResults($this->fruitPlugins, $this->yamlTestPath);
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
