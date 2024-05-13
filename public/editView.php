<?php

require_once dirname(__DIR__, 1) . '/autoload.php';

use Filesystem\Models\File;
use Filesystem\Models\Info;
use Filesystem\Models\Project;
use Filesystem\Models\Keyword;

$project;
$fileinfos;
$keywords;


// Equals Update
if (isset($_GET['project_id'])) {
    $project = Project::find($_GET['project_id']);

    if ($project = Project::find($_GET['project_id'])) {
        $fileinfos = Info::findByProjectId($_GET['project_id']);

        // Get all keywords for project
        $keywords = Keyword::getByProjectId($_GET['project_id']);
    } else {
        echo "Project not found<br>";
        echo "<a href='index.php'>Back</a>";
        die();
        // header("Location: index.php");
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_GET['project_id'])) {
        $project = Project::find($_GET['project_id']);
    } else {
        $project = new Project();
    }

    $project->name = $_POST['name'];
    $project->desc = $_POST['desc'];

    // Create or Update Project
    $project->save();


    if (count($_FILES['multipleFiles']['name'])) {
        // Foreach file
        for ($i = 0; $i < count($_FILES['multipleFiles']['name']); $i++) {
            $filename = basename($_FILES['multipleFiles']['name'][$i]);
            if (empty($filename)) {
                continue;
            }

            $tmpName = $_FILES['multipleFiles']['tmp_name'][$i];

            $size = $_FILES['multipleFiles']['size'][$i];
            $mime_type = $_FILES['multipleFiles']['type'][$i];

            $fp = fopen($tmpName, 'r');
            $fileContent = fread($fp, filesize($tmpName));
            $fileContent = addslashes($fileContent);
            fclose($fp);


            // $uploadfile = $_FILES['multipleFiles']['tmp_name'][$i];
            // $targetpath = dirname(__DIR__, 1) . "/uploads/" . $filename;

            // move_uploaded_file($uploadfile, $targetpath);

            // // $fileContent = file_get_contents($targetpath);
            // $fp = fopen($targetpath, 'r');
            // $fileContent = fread($fp, filesize($targetpath));
            // $fileContent = addslashes($fileContent);
            // fclose($fp);


            // $mime_type = $_FILES['multipleFiles']['type'][$i];
            // $size = $_FILES['multipleFiles']['size'][$i];

            if ($size == 0) {
                // unlink($targetpath);
                continue;
            }

            // Save file
            $file = File::create($fileContent);
            $file->save();

            // Save info
            $info = Info::create(
                $filename,
                $mime_type,
                $size,
                $project->id,
                $file->id
            );
            $info->save();

            // unlink($targetpath);
        }
        unset($_FILES);
        unset($_POST);
        header("Refresh:0");
    }
}



?>

<!DOCTYPE html>
<html lang="de" class="min-vh-100" data-bs-theme="dark">
<?php
$title = "Projekte Editieren";
include __DIR__ . '/components/head.php';
?>

<body>

    <?php
    include __DIR__ . '/components/crossLogo.php';
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6">
                <form action="" method="POST" enctype="multipart/form-data" id="uploadForm">


                    <div class="form-floating ">
                        <input type="text" class="form-control" id="name" list="name" name="name"
                            placeholder="Beschreibung Projekt" autocomplete="off" value="<?= $project->name ?? '' ?>"
                            required>
                        <label for="name">Name</label>
                    </div>

                    <div class="form-floating ">
                        <textarea class="form-control my-4" id="desc" list="desc" name="desc"
                            placeholder="Beschreibung Projekt" autocomplete="off"
                            required><?= $project->desc ?? '' ?></textarea>
                        <label for="desc">Beschreibung</label>
                    </div>


                    <div class="form-floating mt-5">

                        <input type="file" id="multipleFiles" name="multipleFiles[]" multiple>

                        <!-- <button id="submitFiles" type="submit" class="btn btn-primary position-relative">Projekt erstellen</button> -->
                    </div>

                    <div>
                        <?php
                        if (isset($fileinfos) && $fileinfos) {
                            foreach ($fileinfos as $info) {
                                echo "<div id='$info->files_id' class='d-flex justify-content-between my-3'>";
                                echo "  <p class='m-0'>" . $info->name . "</p>";
                                echo "  <button type='button' onclick=\"downloadFile($info->projects_id, $info->files_id)\" class='btn btn-success'>Herunterladen</button>";
                                echo "  <button type='button' onclick=\"deleteFile($info->projects_id, $info->files_id)\" class='btn btn-danger'>Löschen</button>";
                                echo "</div>";
                            }
                        }
                        ?>

                    </div>

                    <!-- <button class="btn btn-danger position-relative" id="clearButton" onclick="form.reset()">Projekt
                        Leeren</button> -->
                    <button type="submit" class="btn btn-primary position-relative">Projekt speichern</button>
                </form>

                <form action="getKeyword.php" method="get">
                    <div class="form-group position-relative col-sm-3 my-4">

                        <div class="mx-auto d-flex flex-wrap justify-content-center mb-3 gap-1 bg-body-secondary"
                            id="selectedKeywordsContainer"></div>

                    </div>
                </form>
                <form action="setKeyword.php" method="post">
                    <div class="d-flex flex-column col-5 justify-content-between">

                        <input type="text" class="form-control" id="formGroupInput" list="keywordBox" name="term"
                            placeholder="Nach Keyword suchen" autocomplete="off">

                        <div id="keywordBox" class="list-group overflow-y-scroll"></div>

                        <button type="submit" class="btn btn-primary position-absolute start-50">Verknüpfen</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/js/editView.js"></script>
    <?php
    require __DIR__ . '/components/scriptSrc.php';
    ?>
</body>

</html>