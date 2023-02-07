<?php
session_start();
include "../../site/services/db_connect.php";

$username = $_SESSION["username"];

 

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../services/login.php");
    exit;
}

if (session_id() == '') {
    session_start();
}
?>

<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AEBO-Library</title>
    <link rel="icon" type="image/x-icon" href="../../assets/svg/favicon.svg">

    <link href=../../assets/vendor/bootstrap/bootstrap.min.css rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style/style.css">

    <style>
        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }
    </style>

</head>


<body class="text-center">
<main class="form-signin w-100 m-auto">
    <form class="form-horizontal" action="db_import_books.php" method="post" name="upload_excel"
          enctype="multipart/form-data">
        <img src="../../assets/images/icons/logo.svg" class="rounded mx-auto d-block img-fluid mb-5 mt-5">
        <h1 class="h3 mb-3 fw-normal mb-5">.csv Datei wählen</h1>

        <div class="mb-3">
            <input class="form-control" type="file" id="formFile" name="file">
        </div>
        <a class="w-100 btn btn-lg btn-primary mt-5" href="admin.php" role="button">Zurück</a>
        <button class="w-100 btn btn-lg btn-primary mt-3" type="submit" name="DataImport" data-loading-text="Loading...">
            Submit
        </button>
        <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
    </form>
</main>
<!--  Bootstrap -->
<script src="../../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>

