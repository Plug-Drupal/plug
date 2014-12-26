<?php

/**
 * @file
 * Contains Drupal\plug_example\Plugin\name\Lullabot
 */

namespace Drupal\plug_example\Plugin\name;

/**
 * Class Lullabot
 * @package Drupal\plug_example\Plugin\name
 *
 * @Name(
 *   id = "lullabot",
 *   company = TRUE
 * )
 */
class Lullabot extends NameBase implements NameInterface {
  protected $name = 'Lullabot';
}
