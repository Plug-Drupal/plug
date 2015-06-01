<?php

/**
 * @file
 * Basic tests cases for plug module.
 */

namespace Drupal\plug\Tests;

use Drupal\plug\Util\Module;

class PlugBasicTest extends \DrupalWebTestCase {

  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => 'Plug tests',
      'description' => 'Plug basic tests',
      'group' => 'Plug',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp('plug');
  }

  /**
   * Checks the Module::getModuleDirectories() method.
   */
  public function testModuleDirectories() {
    $expected_values = array (
      'plug' => drupal_get_path('module', 'plug'),
      'field' => 'modules/field',
      'field_sql_storage' => 'modules/field/modules/field_sql_storage',
      'filter' => 'modules/filter',
      'node' => 'modules/node',
      'user' => 'modules/user',
      'standard' => 'profiles/standard',
      'system' => 'modules/system',
    );

    $directories = Module::getDirectories();
    $this->assertEqual($expected_values, array_intersect_assoc($directories, $expected_values));

    $cached_data = cache_get('module_directories');
    $this->assertEqual($expected_values, array_intersect_assoc($cached_data->data, $expected_values));
  }

  /**
   * Checks the Module::getNamespaces() method.
   */
  public function testModuleNamespaces() {
    $expected_values = array(
      'Drupal\\plug' => drupal_get_path('module', 'plug') . '/src',
      'Drupal\\field' => 'modules/field/src',
      'Drupal\\field_sql_storage' => 'modules/field/modules/field_sql_storage/src',
      'Drupal\\filter' => 'modules/filter/src',
      'Drupal\\node' => 'modules/node/src',
      'Drupal\\user' => 'modules/user/src',
      'Drupal\\standard' => 'profiles/standard/src',
      'Drupal\\system' => 'modules/system/src',
    );

    $namespaces = Module::getNamespaces();
    $this->assertEqual($expected_values, array_intersect_assoc($namespaces->getArrayCopy(), $expected_values));

    $cached_data = cache_get('module_namespaces');
    $this->assertEqual($expected_values, array_intersect_assoc($cached_data->data, $expected_values));
  }

}
