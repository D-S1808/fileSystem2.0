<?php

namespace Filesystem\Models;

use Filesystem\Helpers\DatabaseHelper;

class Project
{
    public bool $exists = false;
    public ?int $id;
    public string $name;
    public string $desc;
    public bool $is_active = true;

    public static function find($id): false|Project
    {
        $conn = DatabaseHelper::connect();
        $query = $conn->prepare("SELECT * FROM projects where id = ? AND is_active = 1 LIMIT 1");
        $query->bind_param("i", $id);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows == 0) {
            return false;
        }

        $row = $result->fetch_assoc();

        return self::create($row['name'], $row['desc'], true, $row['id']);
    }

    public static function search($search): false|array
    {
        $conn = DatabaseHelper::connect();
        $searchFormatted = '%' . $search . '%';

        $query = $conn->prepare("SELECT * FROM projects where `name` and is_active = 1 like ?");
        $query->bind_param("s", $searchFormatted);

        $query->execute();

        $result = $query->get_result();

        if ($result->num_rows == 0) {
            return false;
        }

        $projects = [];

        while ($row = $result->fetch_assoc()) {
            $projects[] = self::create($row['name'], true, $row['id']);
        }

        return $projects;
    }

    public static function getByKeywordId($keywordId): false|array
    {
        $conn = DatabaseHelper::connect();
        $query = $conn->prepare("SELECT * FROM projects AS p LEFT JOIN projects_has_keywords AS pk ON p.id = pk.projects_id WHERE pk.keywords_id = ? and p.is_active = 1");

        $query->bind_param("i", $keywordId);

        $query->execute();
        $results = $query->get_result();
        $rows = $results->fetch_all();

        if ($rows === null) {
            return false;
        }

        $projects = [];

        foreach ($rows as $row) {
            $projects[] = self::create($row['name'], $row['desc'], true, $row['id']);
        }

        return $projects;
    }

    public static function create(string $name, string $desc, bool $exists = false, ?int $id = null): Project
    {
        // Create user instance (Self -> this class (user))
        $project = new Project();

        $project->id = $id;
        $project->name = $name;
        $project->desc = $desc;
        $project->exists = $exists;

        return $project;
    }


    public function save(): bool
    {
        $conn = DatabaseHelper::connect();

        // Choose query depending on whether instance exists or not
        $sqlStatement = $this->exists ?
            "UPDATE projects SET `name` = ?, `desc` = ? WHERE  `id` = ?" :
            "INSERT INTO projects (`name`, `desc`) VALUES (?,?)";

        $query = $conn->prepare($sqlStatement);

        // If exists = UPDATE -> id is required
        if ($this->exists) {
            $query->bind_param(
                'ssi',
                $this->name,
                $this->desc,
                $this->id
            );
        } else {
            $query->bind_param(
                'ss',
                $this->name,
                $this->desc,
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