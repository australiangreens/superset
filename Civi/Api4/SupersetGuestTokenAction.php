<?php

namespace Civi\Api4;

use Civi;
use CRM_Core_Session as Session;
use GuzzleHttp;

class SupersetGuestTokenAction extends Generic\BasicGetAction {

  private static $access_token;
  private static $http_client;

  public function fields() {
    return [
      [
        'name'        => 'guest_token',
        'data_type'   => 'String',
        'description' => 'JWT used to embed Superset dashboards',
      ],
    ];
  }

  public static function getter($action) {
    $user_id = Session::getLoggedInContactID();
    $user_data = self::userData($user_id);
    $embed_ids = self::embeddableDashboardIDs($user_id);
    $guest_token = self::guestToken($user_data, $embed_ids);

    return [[ 'guest_token' => $guest_token ]];
  }

  private static function accessToken() {
    if (empty(self::$access_token)) {
      $client = self::client();
      $settings = Civi::settings();

      $login_response = $client->request('POST', 'security/login', [
        'headers' => [
          'Content-Type' => 'application/json',
        ],
        'body' => json_encode([
          'password' => $settings->get('superset_password'),
          'provider' => 'db',
          'refresh'  => FALSE,
          'username' => $settings->get('superset_username'),
        ]),
      ]);

      $res_body = json_decode((string) $login_response->getBody(), TRUE);

      self::$access_token = $res_body['access_token'];
    }

    return self::$access_token;
  }

  private static function client() {
    if (empty(self::$http_client)) {
      self::$http_client = new GuzzleHttp\Client([
        'base_uri' => Civi::settings()->get('superset_base_url') . "/api/v1/",
      ]);
    }

    return self::$http_client;
  }

  private static function decodeToken($token) {
    list($header, $payload, $signature) = explode('.', $token);

    return [
      'header'    => json_decode(base64_decode($header), TRUE),
      'payload'   => json_decode(base64_decode($payload), TRUE),
      'signature' => $signature,
    ];
  }

  private static function embeddableDashboardIDs($user_id) {
      $dashboards = \CRM_Superset_BAO_SupersetDashboard::getViewableForUser($user_id);

      return array_map(fn ($db) => $db['embed_id'], $dashboards);
  }

  private static function guestToken($user_data, $embed_ids) {
    $client = self::client();
    $access_token = self::accessToken();

    $guest_token_response = $client->request('POST', 'security/guest_token', [
      'headers' => [
        'Authorization' => "Bearer $access_token",
        'Content-Type'  => 'application/json',
      ],
      'body' => json_encode([
        'user' => [
          'username'   => $user_data['display_name'],
          'first_name' => $user_data['first_name'] ?? "",
          'last_name'  => $user_data['last_name'] ?? "",
        ],
        'resources' => array_map(fn ($id) => [
          'id'   => $id,
          'type' => 'dashboard',
        ], $embed_ids),
        'rls' => [],
      ]),
    ]);

    $res_body = json_decode((string) $guest_token_response->getBody(), TRUE);

    return $res_body['token'];
  }

  private static function userData($user_id) {
    return Contact::get(FALSE)
      ->addSelect('display_name', 'first_name', 'last_name')
      ->addWhere('id', '=', $user_id)
      ->execute()
      ->first();
  }

}
