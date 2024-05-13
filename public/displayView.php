<!DOCTYPE html>
<html lang="de" class="min-vh-100" data-bs-theme="dark">

<!-- Head of HTML taken from head.php, when searching for keywords title changes to "Suche" -->
<?php
$title = "Projekt Resulate";

require __DIR__ . '/components/head.php';
require_once dirname(__DIR__, 1) . '/autoload.php';
require_once __DIR__ . '/components/crossLogo.php';
?>

<body>
    <div>
        <form action="getKeyword.php" method="get">
            <div class="mx-auto w-25 d-flex justify-content-center mb-3 gap-1 bg-body-secondary"
                id="selectedKeywordsContainer">
            </div>

            <div class="form-group position-relative col-sm-2 mx-auto">
                <input type="text" class="form-control" id="formGroupInput" list="keywordBox" name="term"
                    placeholder="Nach Keyword suchen" autocomplete="off">

                <div id="keywordBox" class="list-group overflow-y-scroll"></div>

                <button type="submit" class="btn btn-primary position-absolute start-100 top-0 mx-2">Suchen</button>
            </div>
            <div>
                <table class="table table-striped w-50 mx-auto mt-5 ">
                    <tr class="bg-body-primary">
                        <th>Name Projekt</th>
                        <th>Zuletzt geändert</th>
                        <th>Ändern</th>
                        <th>Auswählen</th>
                    </tr>
                    <tr>
                        <td>Praxis Intern</td>
                        <td>13.09.2014</td>
                        <td class="bg-primary">Editieren</td>
                        <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                    </tr>
                    <tr>
                        <td>Praxis Demo</td>
                        <td>08.11.2019</td>
                        <td class="bg-primary">Editieren</td>
                        <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                    </tr>
                    <tr>
                        <td>Praxis Test</td>
                        <td>18.08.2003</td>
                        <td class="bg-primary">Editieren</td>
                        <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                    </tr>
                </table>
            </div>
    </div>
    <?php
    require __DIR__ . '/components/scriptSrc.php';
    ?>
</body>