<?php
require_once dirname(__DIR__, 2) . '/autoload.php';

use Filesystem\Helpers\ResponseHelper;
use Filesystem\Models\File;
use Filesystem\Models\Info;

if (!isset($_GET['projects_id']) || !isset($_GET['files_id'])) {
    ResponseHelper::sendJsonResponse(['error' => 'Missing projects_id or files_id'], 400);
}

Info::delete(intval($_GET['projects_id']), intval($_GET['files_id']));
File::delete(intval($_GET['files_id']));

ResponseHelper::sendJsonResponse([], 200);