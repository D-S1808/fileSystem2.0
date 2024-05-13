<?php
// Linking to ResponseHelper.php for getKeyWord.php
require_once (__DIR__ . "/helpers/ResponseHelper.php");
require_once (__DIR__ . "/helpers/DatabaseHelper.php");
require_once (__DIR__ . "/models/Keyword.php");
require_once (__DIR__ . "/models/File.php");
require_once (__DIR__ . "/models/Info.php");
require_once (__DIR__ . "/models/Project.php");


define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'winmed');
define('DB_DATABASE', 'projectsDB');
