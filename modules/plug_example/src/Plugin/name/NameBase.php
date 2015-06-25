<?php

/**
 * @file
 * Contains Drupal\plug_example\Plugin\name\NameBase
 */

namespace Drupal\plug_example\Plugin\name;

use Drupal\Component\Plugin\PluginBase;

abstract class NameBase extends PluginBase implements NameInterface {

  /**
   * The name.
   *
   * @var string
   */
  protected $name;

  /**
   * {@inheritdoc}
   */
  public function displayName() {
    $definition = $this->getPluginDefinition();
    $replacement = empty($this->configuration['em']) ? '@name' : '%name';
    if ($definition['company']) {
      return $this::t('Company name: ' . $replacement . ' Inc.', array(
        $replacement => $this->name,
      ));
    }
    return $this::t('My name is: ' . $replacement, array(
      $replacement => $this->name,
    ));
  }

  /**
   * @param string $string
   *   A string containing the English string to translate.
   * @param array $args
   *   An associative array of replacements to make after translation. Based
   *   on the first character of the key, the value is escaped and/or themed.
   *   See format_string() for details.
   * @param array $options
   *   An associative array of additional options, with the following elements:
   *   - 'langcode' (defaults to the current language): The language code to
   *     translate to a language other than what is used to display the page.
   *   - 'context' (defaults to the empty context): The context the source string
   *     belongs to.
   *
   * @return string
   *   The translated string.
   *
   * @see t().
   */
  protected static function t($string, array $args = array(), array $options = array()) {
    return t($string,$args, $options);
  }

}
