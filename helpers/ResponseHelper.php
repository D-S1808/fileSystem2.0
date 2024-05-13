<?php
// Creating Namespace for class ResponseHelper
namespace Filesystem\Helpers;

// Check for HTML status; if status code = 200 then HTML request OK, initialize associative array (ID => Data)
class ResponseHelper
{
    public static function sendJsonResponse(array $data = [], int $code = 200): void
    {
        header('Content-Type: application/json');


        echo json_encode(
            [
                'code' => $code,
                'data' => $data
            ]
        );

        die();
    }


    public static function sendJsonResponseKeywords(array $keywords = [], int $code = 200): void
    {
        header('Content-Type: application/json');

        $data = [];

        if (!empty($keywords)) {
            foreach ($keywords as $keyword) {
                $data[] = $keyword->name;
            }
        }

        echo json_encode(
            [
                'code' => $code,
                'data' => $data
            ]
        );

        die();
    }
}