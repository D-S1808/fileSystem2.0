<?php

namespace Filesystem\Models;

use Filesystem\Helpers\DatabaseHelper;

class Keyword
{
    public bool $exists = false;
    public ?int $id;
    public string $name;

    public static function find($id): false|Keyword
    {
        $conn = DatabaseHelper::connect();
        $query = $conn->prepare("SELECT * FROM keywords where id = ? LIMIT 1");
        $query->bind_param("i", $id);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows == 0) {
            return false;
        }

        $row = $result->fetch_assoc();

        return self::create($row['name'], true, $row['id']);
    }

    public static function search($search): false|array
    {
        $conn = DatabaseHelper::connect();
        $searchFormatted = '%' . $search . '%';

        $query = $conn->prepare("SELECT * FROM keywords where `name` like ?");
        $query->bind_param("s", $searchFormatted);

        $query->execute();

        $result = $query->get_result();

        if ($result->num_rows == 0) {
            return false;
        }

        $keywords = [];

        while ($row = $result->fetch_assoc()) {
            $keywords[] = self::create($row['name'], true, $row['id']);
        }

        return $keywords;
    }

    public static function all(): false|array
    {
        $conn = DatabaseHelper::connect();
        $query = $conn->prepare("SELECT * FROM keywords ORDER BY `name`");

        $query->execute();
        $results = $query->get_result();
        $rows = $results->fetch_all();

        if ($rows === null) {
            return false;
        }

        $keywords = [];

        foreach ($rows as $row) {
            $keywords[] = self::create($row['name'], true, $row['id']);
        }

        return $keywords;
    }

    public static function getByProjectId($projectId): false|array
    {
        $conn = DatabaseHelper::connect();
        $query = $conn->prepare("SELECT * FROM keywords AS k LEFT JOIN projects_has_keywords AS pk ON k.id = pk.keywords_id WHERE pk.projects_id = ?");

        $query->bind_param("i", $projectId);

        $query->execute();
        $results = $query->get_result();
        $rows = $results->fetch_all();

        if ($rows === null) {
            return false;
        }

        $projects = [];

        foreach ($rows as $row) {
            $projects[] = self::create($row['name'], true, $row['id']);
        }

        return $projects;
    }

    public static function create(string $name, bool $exists = false, ?int $id = null): Keyword
    {
        // Create user instance (Self -> this class (user))
        $keyword = new Keyword();

        $keyword->id = $id;
        $keyword->name = $name;
        $keyword->exists = $exists;

        return $keyword;
    }


    public function save(): bool
    {
        $conn = DatabaseHelper::connect();

        // Choose query depending on whether instance exists or not
        $sqlStatement = $this->exists ?
            "UPDATE keywords SET `name` = ? WHERE  `id` = ?" :
            "INSERT INTO keywords (`name`) VALUES (?)";

        $query = $conn->prepare($sqlStatement);

        // If exists = UPDATE -> id is required
        if ($this->exists) {
            $query->bind_param(
                'si',
                $this->name,
                $this->id
            );
        } else {
            $query->bind_param(
                's',
                $this->name,
            );
        }

        // If successful
        if ($query->execute()) {
            if (!$this->exists) {
                $this->id = $conn->insert_id;
                $this->exists = true;
            }
            return true;
        }

        return false;
    }

}