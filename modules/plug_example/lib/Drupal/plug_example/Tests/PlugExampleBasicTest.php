<?php

/**
 * @file
 * Basic tests cases for plug_example module.
 */

namespace Drupal\plug_example\Tests;

use Drupal\plug_example\NamePluginManager;

class PlugExampleBasicTest extends \DrupalWebTestCase {

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
   * Expected output for extra name plugins.
   *
   * @var array
   */
  protected $extraNamePlugins = array('Company name: New Acme Inc.');

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
   * Expected output for extra fruit plugins.
   *
   * @var array
   */
  protected $extraFruitPlugins = array('Fruit name: Pear');

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
    parent::setUp('plug_example');
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
   * Tests the annotated plugin discovery in multiple modules.
   */
  public function testAnnotatedDiscovery() {
    $this->assertTestModulePlugins($this->namePlugins, $this->extraNamePlugins, $this->annotatedTestPath, $this->nameCache);
  }

  /**
   * Tests the YAML plugin discovery in multiple modules.
   */
  public function testYamlDiscovery() {
    $this->assertTestModulePlugins($this->fruitPlugins, $this->extraFruitPlugins, $this->yamlTestPath, $this->fruitCache);
  }

  /**
   * Asserts the number of items in a XPath selector.
   *
   * @param string $xpath
   *   The XPath selector.
   * @param int $count
   *   The expected number of items in the selector.
   *
   * @return bool
   *  TRUE on pass, FALSE on fail.
   */
  protected function assertCountXpathItems($xpath, $count) {
    return $this->assertEqual(count($this->xpath($xpath)), $count);
  }

  /**
   * Checks the example page content.
   *
   * @param array $results
   *   Array containing the expected output.
   * @param $path
   *   Path to the test page.
   */
  protected function assertExamplePageResults(array $results, $path) {
    $this->drupalGet($path);
    // Check the page title.
    $this->assertTitle('Plugins example | Drupal');
    // Check the number of plugins discovered is the expected.
    $this->assertCountXpathItems('//*[@id="block-system-main"]//li', count($results));
    // Assert displayName() results for each plugin.
    foreach ($results as $result) {
      $this->assertText($result);
    }
  }

  /**
   * Checks the behavior when enabling/disabling plug_test module.
   *
   * @param array $results
   *   Array containing the base plugins defined in plug_example module.
   * @param array $extra
   *   Array containing the extra plugins defined in plug_test module.
   * @param $path
   *   Path to the test page.
   * @param $cid
   *   Cache id related to the plugin type
   */
  protected function assertTestModulePlugins(array $results, array $extra, $path, $cid) {
    module_enable(array('plug_test'));
    cache_clear_all($cid, 'cache');

    $this->assertExamplePageResults(array_merge($results, $extra), $path);

    module_disable(array('plug_test'));
    cache_clear_all($cid, 'cache');

    $this->assertExamplePageResults($results, $path);
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
