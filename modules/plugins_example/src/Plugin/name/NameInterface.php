<?php

/**
 * @file
 * Contains Drupal\plugins_example\Plugin\name\NameInterface
 */

namespace Drupal\plugins_example\Plugin\name;

interface NameInterface {

  /**
   * Displays a name.
   *
   * @return string
   */
  public function displayName();

}
