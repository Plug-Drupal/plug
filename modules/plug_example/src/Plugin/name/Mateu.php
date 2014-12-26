<?php

/**
 * @file
 * Contains Drupal\plug_example\Plugin\name\Mateu
 */

namespace Drupal\plug_example\Plugin\name;

/**
 * Class Mateu
 * @package Drupal\plug_example\Plugin\name
 *
 * @Name(
 *   id = "mateu",
 *   company = FALSE
 * )
 */
class Mateu extends NameBase implements NameInterface {

  protected $name = 'Mateu';

}
