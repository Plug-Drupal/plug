<?php

/**
 * @file
 * Contains Drupal\plug_example\Plugin\name\JohnTest
 */

namespace Drupal\plug_example\Plugin\name;

/**
 * Class John
 * @package Drupal\plug_example\Plugin\name
 *
 * @Name(
 *   id = "john_test",
 *   company = FALSE
 * )
 */
class JohnTest extends John {

  /**
   * Overrides NameBase::t().
   *
   * Overrides the translation method to avoid bootstrap.
   */
  protected static function t($string, array $args = array(), array $options = array()) {
    return $string;
  }

}
