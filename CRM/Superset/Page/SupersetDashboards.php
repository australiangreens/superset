<?php

use Civi\Api4;
use CRM_Superset_ExtensionUtil as E;

class CRM_Superset_Page_SupersetDashboards extends CRM_Core_Page {

  public function run() {
    // Include resources
    $resources = Civi::resources();
    $resources->addScriptUrl('https://unpkg.com/@superset-ui/embedded-sdk');
    $resources->addScriptFile('superset', 'js/embed-superset.js');
    $resources->addStyleFile('superset', 'css/superset.css');

    $resources->addVars('superset', [
      'SUPERSET_BASE_URL' => Civi::settings()->get('superset_base_url'),
    ]);

    // Get viewable dashboard IDs
    $user_id = CRM_Core_Session::getLoggedInContactID();
    $viewable_dashboards = CRM_Superset_BAO_SupersetDashboard::getViewableForUser($user_id);
    $embed_ids = array_map(fn ($db) => $db['embed_id'], $viewable_dashboards);

    // List dashboards
    $result = Api4\SupersetDashboard::get(FALSE)->execute();
    $dashboards = [];

    foreach ($result as $dashboard) {
      $dashboard['viewable'] = in_array($dashboard['embed_id'], $embed_ids, TRUE);
      $dashboards[] = $dashboard;
    }

    $this->assign('dashboards', $dashboards);

    // Run
    parent::run();
  }

}
