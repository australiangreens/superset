<?php

use CRM_Superset_ExtensionUtil as E;

return [
  'superset_base_url' => [
    'add'         => '1.0',
    'default'     => NULL,
    'description' => 'URL of the Superset instance to connect to',
    'help_text'   => 'URL of the Superset instance to connect to',
    'html_type'   => 'text',
    'is_contact'  => 0,
    'is_domain'   => 1,
    'name'        => 'superset_base_url',
    'title'       => E::ts('Superset base URL'),
    'type'        => 'String',
  ],
  'superset_username' => [
    'add'         => '1.0',
    'default'     => NULL,
    'description' => 'Username of the external Superset user',
    'help_text'   => 'Username of the external Superset user',
    'html_type'   => 'text',
    'is_contact'  => 0,
    'is_domain'   => 1,
    'name'        => 'superset_username',
    'title'       => E::ts('Superset username'),
    'type'        => 'String',
  ],
  'superset_password' => [
    'add'         => '1.0',
    'default'     => NULL,
    'description' => 'Password of the external Superset user',
    'help_text'   => 'Password of the external Superset user',
    'html_type'   => 'text',
    'is_contact'  => 0,
    'is_domain'   => 1,
    'name'        => 'superset_password',
    'title'       => E::ts('Superset password'),
    'type'        => 'String',
  ],
];
