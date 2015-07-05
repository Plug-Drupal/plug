<?php

/**
 * @file
 * Basic tests cases for plug_example module.
 */

namespace Drupal\plug_example\Tests;

class ExtraTest extends BaseTest {

  /**
   * Expected output for extra name plugins.
   *
   * @var array
   */
  protected $extraNamePlugins = array('Company name: New Acme Inc.');

  /**
   * Expected output for extra fruit plugins.
   *
   * @var array
   */
  protected $extraFruitPlugins = array('Fruit name: Pear');


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => 'Plug Example extra tests',
      'description' => 'Plug example extra tests',
      'group' => 'Plug',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp('registry_autoload', 'plug_example', 'plug_test');
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

}
