<?php

/**
 * @file
 * Contains Drupal\plug_example\Tests\BaseTest.
 */

namespace Drupal\plug_example\Tests;

class BaseTest extends \DrupalWebTestCase {

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
   * @var \Drupal\plug_example\NamePluginManager
   */
  protected $manager;

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
    $modules = array('plug_test');
    module_enable($modules);
    cache_clear_all($cid, 'cache');

    $this->assertExamplePageResults(array_merge($results, $extra), $path);

    module_disable($modules);
    drupal_uninstall_modules($modules);
    cache_clear_all($cid, 'cache');

    $this->assertExamplePageResults($results, $path);
  }

}
