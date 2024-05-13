<?php

require_once dirname(__DIR__, 2) . '/autoload.php';

use Filesystem\Helpers\ResponseHelper;
use Filesystem\Models\File;
use Filesystem\Models\Info;

if (!isset($_GET['projects_id']) || !isset($_GET['files_id'])) {
    ResponseHelper::sendJsonResponse(['error' => 'Missing projects_id or files_id'], 400);
}


$info = Info::find(intval($_GET['projects_id']), intval($_GET['files_id']));
$file = File::find(intval($_GET['files_id']));


header("Content-length: $info->size");
header("Content-type: $info->mime_type");
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=$info->name");
header("Content-Type: application/octet-stream;");


echo $file->blob;