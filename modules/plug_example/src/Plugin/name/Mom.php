<?php

/**
 * @file
 * Contains Drupal\pugins_example\Plugin\name\Mom
 */

namespace Drupal\plug_example\Plugin\name;

/**
 * Class Mom
 * @package Drupal\pugins_example\Plugins
 *
 * @Plugin(
 *   id = "mom",
 *   company = FALSE
 * )
 */
class Mom extends NameBase implements NameInterface {

  protected $name = 'Mom';

}
