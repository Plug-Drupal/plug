<?php

/**
 * @file
 * Contains Drupal\plug_example\Plugin\name\NameInterface
 */

namespace Drupal\plug_example\Plugin\name;

interface NameInterface {

  /**
   * Displays a name.
   *
   * @return string
   */
  public function displayName();

}
