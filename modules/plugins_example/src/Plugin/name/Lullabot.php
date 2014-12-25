<?php

/**
 * @file
 * Contains Drupal\pugins_example\Plugin\name\Lullabot
 */

namespace Drupal\plugins_example\Plugin\name;

/**
 * Class Lullabot
 * @package Drupal\pugins_example\Plugins
 *
 * @Plugin(
 *   id = "lullabot",
 *   company = TRUE
 * )
 */
class Lullabot extends NameBase implements NameInterface {
  protected $name = 'Lullabot';
}
