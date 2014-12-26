<?php

/**
 * @file
 * Contains Drupal\pugins_example\Plugin\name\Mateu
 */

namespace Drupal\plug_example\Plugin\name;

/**
 * Class Mateu
 * @package Drupal\pugins_example\Plugins
 *
 * @Plugin(
 *   id = "mateu",
 *   company = FALSE
 * )
 */
class Mateu extends NameBase implements NameInterface {

  protected $name = 'Mateu';

}
