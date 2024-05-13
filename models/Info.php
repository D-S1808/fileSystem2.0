<?php

namespace Filesystem\Models;

use Filesystem\Helpers\DatabaseHelper;

class Info
{
    public bool $exists = false;
    public ?int $id;
    public string $name;
    public string $mime_type;
    public int $size;
    public int $projects_id;
    public int $files_id;

    public static function find($projects_id, $files_id): false|Info
    {
        $conn = DatabaseHelper::connect();
        $query = $conn->prepare("SELECT * FROM infos where projects_id = ? AND files_id = ? LIMIT 1");
        $query->bind_param("ii", $projects_id, $files_id);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows == 0) {
            return false;
        }

        $row = $result->fetch_assoc();

        return self::create($row['name'], $row['mime_type'], $row['size'], $row['projects_id'], $row['files_id'], $row['id']);
    }

    public static function findByProjectId(int $projectId): false|array
    {
        $conn = DatabaseHelper::connect();
        $query = $conn->prepare("SELECT * FROM infos WHERE projects_id = ?");
        $query->bind_param("i", $projectId);

        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows == 0) {
            return false;
        }

        $projects = [];

        while ($row = $result->fetch_assoc()) {
            $projects[] = self::create($row['name'], $row['mime_type'], $row['size'], $row['projects_id'], $row['files_id'], $row['id']);
        }

        return $projects;
    }

    public static function create(string $name, string $mime_type, int $size, int $projects_id, int $files_id, ?int $id = null): Info
    {
        // Create user instance (Self -> this class (user))
        $info = new Info();

        $info->id = $id;
        $info->name = $name;
        $info->mime_type = $mime_type;
        $info->size = $size;
        $info->projects_id = $projects_id;
        $info->files_id = $files_id;

        return $info;
    }

    public static function delete(int $projectId, int $fileId): bool
    {
        $conn = DatabaseHelper::connect();
        $query = $conn->prepare("DELETE FROM infos where projects_id = ? AND files_id = ? ");
        $query->bind_param("ii", $projectId, $fileId);
        if ($query->execute()) {
            return true;
        }

        return false;
    }
    public static function deleteProjectId(int $projectId): bool
    {
        $conn = DatabaseHelper::connect();
        $query = $conn->prepare("DELETE FROM infos where projects_id = ?");
        $query->bind_param("i", $projectId);
        if ($query->execute()) {
            return true;
        }

        return false;
    }


    public function save(): bool
    {
        $conn = DatabaseHelper::connect();

        $query = $conn->prepare("INSERT INTO infos (`name`,`mime_type`,`size`,`projects_id`,`files_id`) VALUES (?,?,?,?,?)");

        $query->bind_param(
            'ssiii',
            $this->name,
            $this->mime_type,
            $this->size,
            $this->projects_id,
            $this->files_id,
        );

        // If successful
        if ($query->execute()) {

            $this->id = $conn->insert_id;
            return true;

        }

        return false;
    }

}