<?php
use CRM_Superset_ExtensionUtil as E;

return [
  'name' => 'SupersetDashboard',
  'table' => 'civicrm_superset_dashboard',
  'class' => 'CRM_Superset_DAO_SupersetDashboard',
  'getInfo' => fn() => [
    'title' => E::ts('Superset Dashboard'),
    'title_plural' => E::ts('Superset Dashboards'),
    'description' => E::ts('FIXME'),
    'log' => TRUE,
    'label_field' => 'title',
  ],
  'getFields' => fn() => [
    'id' => [
      'title' => E::ts('ID'),
      'sql_type' => 'int unsigned',
      'input_type' => 'Number',
      'required' => TRUE,
      'description' => E::ts('Unique SupersetDashboard ID'),
      'primary_key' => TRUE,
      'auto_increment' => TRUE,
    ],
    'title' => [
      'title' => E::ts('Title'),
      'sql_type' => 'varchar(255)',
      'input_type' => 'Text',
      'description' => E::ts('Title of the dashboard as displayed to users'),
      'input_attrs' => [
        'size' => '40',
      ],
    ],
    'embed_id' => [
      'title' => E::ts('Embed ID'),
      'sql_type' => 'varchar(50)',
      'input_type' => 'Text',
      'required' => TRUE,
      'description' => E::ts('External dashboard ID used to embed in applications'),
      'input_attrs' => [
        'size' => '40',
      ],
    ],
  ],
];
