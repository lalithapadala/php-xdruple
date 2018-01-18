<?php declare(strict_types=1);

/**
 * @file keeps Drupal installation hooks implementations.
 */

use Xtuple\Xdruple\Application\Component\Component\System\Install\InstallComponent;

/**
 * Implements hook_schema().
 *
 * @return array
 */
function xdruple_schema() {
  return _xdruple_application_install_component()->schema();
}

/**
 * Implements hook_schema_alter().
 *
 * @param array $schema
 */
function xdruple_schema_alter(&$schema) {
  _xdruple_application_install_component()->schemaAlter($schema);
}

/**
 * Implements hook_install().
 */
function xdruple_install() {
  _xdruple_application_install_component()->install();
}

/**
 * Implements hook_enable().
 */
function xdruple_enable() {
  _xdruple_application_install_component()->enable();
}

/**
 * Implements hook_disable().
 */
function xdruple_disable() {
  _xdruple_application_install_component()->disable();
}

/**
 * Implements hook_uninstall().
 */
function xdruple_uninstall() {
  _xdruple_application_install_component()->uninstall();
}

function _xdruple_application_install_component(): InstallComponent {
  /** @var InstallComponent $component */
  $component = xdruple_application()->component(InstallComponent::NAME);
  return $component;
}