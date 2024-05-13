<?php
// Link to autoload for ResponseHelper static class sendJsonResponse (through ResponseHelper.php link in autoload.php)
require_once dirname(__DIR__, 1) . "/autoload.php";

// Using namespace from ResponseHelper class
use Filesystem\Helpers\ResponseHelper;
use Filesystem\Models\Keyword;

$keywords = Keyword::search($_GET['term']);

if ($keywords) {
    ResponseHelper::sendJsonResponseKeywords($keywords);
}

ResponseHelper::sendJsonResponseKeywords([], 404);
