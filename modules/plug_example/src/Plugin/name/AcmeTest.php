<?php

/**
 * @file
 * Contains Drupal\plug_example\Plugin\name\AcmeTest
 */

namespace Drupal\plug_example\Plugin\name;

/**
 * Class Acme
 * @package Drupal\plug_example\Plugin\name
 *
 * @Name(
 *   id = "acme_test",
 *   company = TRUE
 * )
 */
class AcmeTest extends Acme {

  /**
   * Overrides NameBase::t().
   *
   * Overrides the translation method to avoid bootstrap.
   */
  protected static function t($string, array $args = array(), array $options = array()) {
    return $string;
  }

}
