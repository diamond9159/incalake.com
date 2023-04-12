<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Capsule\Manager as Capsule;


// Autoload 自动载入
require BASEPATH.'../vendor/autoload.php';
// 载入数据库配置文件
require_once APPPATH.'config/database.php';

// Eloquent ORM

$capsule = new Capsule;

$db['eloquent'] = [
  'driver'    => 'mysql',

  'host'      => $db['default']['hostname'],
  'database'  => $db['default']['database'],
  'username'  => $db['default']['username'],
  'password'  => $db['default']['password'],
  'charset'   => 'utf8',
  'collation' => 'utf8_general_ci',
  'prefix'    => ''
  ];

$capsule->addConnection($db['eloquent']);

$capsule->bootEloquent();