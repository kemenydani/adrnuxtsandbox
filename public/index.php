<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('__ROOT__', __DIR__ . './../');
define('__CONFIG_DIR__', __ROOT__ . '/config/');

require '../vendor/autoload.php';
require '../App/functions.php';

session_start();

require '../App/application.php';
