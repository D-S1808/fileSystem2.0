<?php

namespace Filesystem\Helpers;

use mysqli;

class DatabaseHelper
{
    public static function connect()
    {
        // Create connection
        $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        // Check connection if error output error message
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit();
        }

        return $mysqli;
    }
}