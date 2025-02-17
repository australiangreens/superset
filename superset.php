<?php

require_once 'superset.civix.php';
// phpcs:disable
use CRM_Superset_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function superset_civicrm_config(&$config): void {
  _superset_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function superset_civicrm_install(): void {
  _superset_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function superset_civicrm_enable(): void {
  _superset_civix_civicrm_enable();
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function superset_civicrm_preProcess($formName, &$form): void {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
//function superset_civicrm_navigationMenu(&$menu): void {
//  _superset_civix_insert_navigation_menu($menu, 'Mailings', [
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ]);
//  _superset_civix_navigationMenu($menu);
//}

function superset_civicrm_permission(&$permissions): void {
  $permissions['list superset dashboards'] = [
    'label' => E::ts('Superset: List dashboards'),
    'description' => E::ts('Superset: View a list of all dashboards'),
  ];

  $permissions['access all superset dashboards'] = [
    'label' => E::ts('Superset: Access all dashboards'),
    'description' => E::ts('Superset: Embed and display all Superset dashboards'),
  ];

  $permissions['administer superset dashboards'] = [
    'label' => E::ts('Superset: Administer dashboards'),
    'description' => E::ts('Superset: Create/update/delete Superset dashboards'),
  ];
}
