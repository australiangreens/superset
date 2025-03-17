<?php

use Civi\Api4;
use Civi\Test\CiviEnvBuilder;
use Civi\Test\HeadlessInterface;
use Civi\Test\HookInterface;
use Civi\Test\TransactionalInterface;
use PHPUnit\Framework\TestCase;

/**
 * @group headless
 */
class CRM_Superset_BAO_SupersetDashboardTest
  extends TestCase
  implements HeadlessInterface, HookInterface, TransactionalInterface {

  private $dashboards = [];
  private $users = [];

  public function setUpHeadless(): CiviEnvBuilder {
    return \Civi\Test::headless()
      ->installMe(__DIR__)
      ->apply();
  }

  public function setUp(): void {
    parent::setUp();

    $this->createDashboards(2);
    $this->createUsers(2);
  }

  public function tearDown(): void {
    parent::tearDown();
  }

  public function testGetViewableForUser() {
    $user_perm_class = CRM_Core_Config::singleton()->userPermissionClass;

    // User #1 should only have access to the first dashboard because there is an
    // explicit ACL linked to his contact ID

    $user_perm_class->permissions = [];
    self::grantAccess($this->dashboards[0], ['civicrm_contact', $this->users[0]['id']]);

    $this->assertEquals(
      array_slice($this->dashboards, 0, 1),
      CRM_Superset_BAO_SupersetDashboard::getViewableForUser($this->users[0]['id'])
    );

    // User #2 should have access to all dashboards because he has the
    // permission "access all superset dashboards"

    $user_perm_class->permissions = ['access all superset dashboards'];

    $this->assertEquals(
      array_slice($this->dashboards, 0, 2),
      CRM_Superset_BAO_SupersetDashboard::getViewableForUser($this->users[1]['id'])
    );
  }

  private function createDashboards($n) {
    for ($i = 1; $i <= $n; $i++) {
      $this->dashboards[] = Api4\SupersetDashboard::create(FALSE)
        ->addValue('title'   , "Dashboard #$i")
        ->addValue('embed_id', self::randomUUID())
        ->execute()
        ->first();
    }
  }

  private function createUsers($n) {
    for ($i = 1; $i <= $n; $i++) {
      $this->users[] = Api4\Contact::create(FALSE)
        ->addValue('display_name', "User #$i")
        ->execute()
        ->first();
    }
  }

  private static function grantAccess($dashboard, $entity) {
    list($entity_table, $entity_id) = $entity;

    Api4\ACL::create(FALSE)
      ->addValue('deny'        , FALSE)
      ->addValue('entity_id'   , $entity_id)
      ->addValue('entity_table', $entity_table)
      ->addValue('is_active'   , TRUE)
      ->addValue('name'        , "View {$dashboard['title']}")
      ->addValue('object_id'   , $dashboard['id'])
      ->addValue('object_table', 'civicrm_superset_dashboard')
      ->addValue('operation'   , 'View')
      ->execute();
  }

  private static function randomUUID() {
    $chunks = [];

    while (count($chunks) < 4) {
      $chunks[] = bin2hex(random_bytes(3));
    }

    return implode('-', $chunks);
  }

}
