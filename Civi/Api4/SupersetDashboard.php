<?php

namespace Civi\Api4;

/**
 * SupersetDashboard entity.
 *
 * Provided by the superset extension.
 *
 * @package Civi\Api4
 */
class SupersetDashboard extends Generic\DAOEntity {

  public static function guestToken() {
    return new SupersetGuestTokenAction(
      'SupersetDashboard',
      'guestToken',
      ['Civi\Api4\SupersetGuestTokenAction', 'getter']
    );
  }

  public static function permissions() {
    return [
      'default'    => ['administer CiviCRM', 'administer superset dashboards'],
      'guestToken' => ['list superset dashboards'],
    ];
  }

}
