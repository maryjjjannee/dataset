<?php
    session_start();
    include('server.php');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datasets</title>
    <link rel="icon"
        href="https://static.vecteezy.com/system/resources/previews/009/665/134/original/seo-research-concept-with-a-magnifying-glass-researching-seo-from-a-website-inside-a-computer-vector-computer-website-showing-an-image-icon-and-a-magnifying-glass-searching-for-seo-keywords-concept-free-png.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>
    <?php  include('navbar.php');?>

    <div class="datasetshead mt-5">
        <br>
        <h2>Datasets</h2>
    </div>

    <div class="input-group-newdataset">
        <a href="dataform.php" class="btn" >
        <button type="button" class="btn btn-dark">➕ New dataset</button>
        </a>
        <a href="class.php" class="btn" >
        <button type="button" class="btn btn-outline-dark">your dataset</button>
        </a>
    </div>
</body>

</html>