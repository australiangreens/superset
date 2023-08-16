<?php

class CRM_Superset_BAO_SupersetDashboard extends CRM_Superset_DAO_SupersetDashboard {

  public static function getViewableForUser($user_id) {
    $access_all = CRM_Core_Permission::check('access all superset dashboards');

    if ($access_all) {
      $query = "
        SELECT id, title, embed_id
        FROM civicrm_superset_dashboard;
      ";
    } else {
      $query = "
        SELECT DISTINCT
          ssd.id       AS id,
          ssd.title    AS title,
          ssd.embed_id AS embed_id
        FROM civicrm_superset_dashboard ssd
        INNER JOIN civicrm_acl acl
          ON  acl.object_table = 'civicrm_superset_dashboard'
          AND acl.object_id    = ssd.id
        WHERE
          acl.entity_table  = 'civicrm_contact'
          AND acl.entity_id = %1
        ;
      ";

    }

    $result = CRM_Core_DAO::executeQuery($query, [ 1 => [$user_id, 'String'] ]);
    $dashboards = [];

    while ($result->fetch()) {
      $dashboards[] = $result->toArray();
    }

    return $dashboards;
  }


}
