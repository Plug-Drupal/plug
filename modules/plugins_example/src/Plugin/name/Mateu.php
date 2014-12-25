<?php

/**
 * @file
 * Contains Drupal\pugins_example\Plugin\name\Mateu
 */

namespace Drupal\pugins_example\Plugin\name;

use Drupal\plugins_example\Plugin\name\NameInterface;

/**
 * Class Mateu
 * @package Drupal\pugins_example\Plugins
 *
 * @Plugin(
 *   id = "mateu",
 *   company = FALSE
 * )
 */
class Mateu implements NameInterface {

  protected $name = 'Mateu';

  /**
   * {@inheritdoc}
   */
  public function displayName() {
    return t('My name is: @name', array(
      '@name' => $this->name,
    ));
  }

}
