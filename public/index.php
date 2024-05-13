<!DOCTYPE html>
<html lang="de" class="min-vh-100" data-bs-theme="dark">

<!-- Head of HTML taken from head.php, when searching for keywords title changes to "Suche" -->
<?php
$title = "Suche";

require __DIR__ . '/components/head.php';
require_once dirname(__DIR__, 1) . '/autoload.php';
require_once __DIR__ . '/components/crossLogo.php';
?>

<body>
    <div>
        <form action="getKeyword.php" method="get">
            <div class="mx-auto w-25 d-flex justify-content-center mb-3 gap-1 bg-body-secondary"
                id="selectedKeywordsContainer"></div>

            <div class="form-group position-relative col-sm-2 mx-auto">
                <input type="text" class="form-control" id="formGroupInput" list="keywordBox" name="term"
                    placeholder="Keyword eingeben" autocomplete="off">

                <div id="keywordBox" class="list-group overflow-y-scroll"></div>

                <button type="submit" class="btn btn-primary position-absolute start-100 top-0 mx-2">Suchen</button>

                <a type="button" class="btn btn-primary position-relative start-0 top-0 my-3" role="button"
                    href="editView.php">Projekte</a>
            </div>
        </form>
    </div>

    <?php
    require __DIR__ . '/components/scriptSrc.php';
    ?>
</body>

</html>