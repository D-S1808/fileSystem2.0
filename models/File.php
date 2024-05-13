<?php

namespace Filesystem\Models;

use Filesystem\Helpers\DatabaseHelper;

class File
{
    public ?int $id;
    public string $blob;

    public static function find($id): false|File
    {
        $conn = DatabaseHelper::connect();
        $query = $conn->prepare("SELECT * FROM files where id = ? LIMIT 1");
        $query->bind_param("i", $id);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows == 0) {
            return false;
        }

        $row = $result->fetch_assoc();

        return self::create($row['blob'], $row['id']);
    }

    public static function create(string $blob, ?int $id = null): File
    {
        // Create user instance (Self -> this class (user))
        $file = new File();

        $file->id = $id;
        $file->blob = $blob;

        return $file;
    }

    public static function delete(int $id): bool
    {
        $conn = DatabaseHelper::connect();
        $query = $conn->prepare("DELETE FROM files where id = ?");
        $query->bind_param("i", $id);
        if ($query->execute()) {
            return true;
        }

        return false;
    }


    public function save(): bool
    {
        $conn = DatabaseHelper::connect();

        $query = $conn->prepare("INSERT INTO files (`blob`) VALUES (?)");

        $query->bind_param(
            's',
            $this->blob,
        );


        // If successful
        if ($query->execute()) {
            $this->id = $conn->insert_id;
            return true;
        }

        return false;
    }

}