<?php

use App\Lib\DB;
use App\Lib\Language;

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('__ROOT__', __DIR__ . './../');
define('__CONFIG_DIR__', __ROOT__ . '/config/');
define('__STORAGE_DIR__', __ROOT__ . '/storage/');
define('__UPLOADS_DIR__', __STORAGE_DIR__ . '/uploads/');

require '../vendor/autoload.php';
require '../App/functions.php';
/*
$L = new Language();
echo $L->getLanguage();
$L->setLanguage('hu');
echo $L->getLanguage();
$L->setLanguageFromHttp();
echo $L->getLanguage();
echo (string)$L;
*/


DB::$_PREFIX_ = "";
DB::$_HOST_ = isLocalhost() ? 'sql168.main-hosting.eu' : 'localhost';
DB::$_DATABASE_ = "u277298753_wdp";
DB::$_USERNAME_ = "u277298753_wdp";
DB::$_PASSWORD_ = "webdevplace2018";

session_start();

require '../App/application.php';
