<?php
$title = $title ?? 'Intelligent Filesystem2.0';

// Equal to: 
// $tile = isset($title) ? $title : 'Intelligent Filesystem2.0';

?>
<!-- Head of HTML which implemets Logo, Bootstrap 5 and custom CSS -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link rel="icon" href="/img/winmed_cross_only.svg" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
</head>