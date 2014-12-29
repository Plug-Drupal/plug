<?php

/**
 * @file
 * Contains Drupal\plug_test\Plugin\name\NewAcme
 */

namespace Drupal\plug_test\Plugin\name;

use Drupal\plug_example\Plugin\name\NameBase;
use Drupal\plug_example\Plugin\name\NameInterface;

/**
 * Class NewAcme
 * @package Drupal\plug_example\Plugin\name
 *
 * @Name(
 *   id = "new_acme",
 *   company = TRUE
 * )
 */
class NewAcme extends NameBase implements NameInterface {
  protected $name = 'New Acme';
}
