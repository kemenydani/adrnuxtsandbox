<?php

use App\Lib\DB;

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('__ROOT__', __DIR__ . './../');
define('__CONFIG_DIR__', __ROOT__ . '/config/');
define('__STORAGE_DIR__', __ROOT__ . '/storage/');
define('__UPLOADS_DIR__', __STORAGE_DIR__ . '/uploads/');

define('__LANGUAGES__', ['en', 'hu']);
define('__DEFAULT_LANGUAGE__', 'en');

$httpLanguages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

foreach($httpLanguages as &$entry) $entry = substr($entry, 0, 2);

$languages = array_intersect(array_unique($httpLanguages), __LANGUAGES__);

$httpLanguage = @$languages[0] ? $languages[0] : __DEFAULT_LANGUAGE__;

define('__LANGUAGE__', $httpLanguage);

require '../vendor/autoload.php';
require '../App/functions.php';

DB::$_PREFIX_ = "";
DB::$_HOST_ = isLocalhost() ? 'sql168.main-hosting.eu' : 'localhost';
DB::$_DATABASE_ = "u277298753_wdp";
DB::$_USERNAME_ = "u277298753_wdp";
DB::$_PASSWORD_ = "webdevplace2018";

session_start();

require '../App/application.php';
