<?php
session_start();
include "../../site/services/db_connect.php";

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: ../services/login.php');
    exit;
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AeBo-Web</title>
    <link rel="icon" type="image/x-icon" href="../../assets/svg/favicon.svg">

    <link href=../../assets/vendor/bootstrap/bootstrap.min.css rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style/style.css">
    <!--  Bootstrap -->
    <script src="../../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="../../assets/vendor/jquery/jquery-3.5.1.js"></script>
    <!--Script-->
    <script src="../../assets/vendor/js/script.js"></script>


</head>

<body>
    <?php
    $showSearch = false;
    $showEmpDatalist = false;
    include "../services/nav.php";
    setnavvalues($showSearch, $showEmpDatalist); ?>


    <div class="d-flex align-items-center vh-100 admin_index_background">
        <div class="m-auto">
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-md-12 m-3">
                        <h1>Adminbereich</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex flex-row col-md-12 justify-content-center">
                        <div class="card border-0 m-2" style="width: 18rem;">
                            <div class="card-body ">
                                <h5 class="card-title">Bibliothek</h5>
                                <a href="../admin/library.php" class="card-link">Schnellzugriff</a>
                            </div>
                        </div>
                        <div class="card border-0 m-2" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Zeitschriftenverwaltung</h5>
                                <a href="../admin/magazines.php" class="card-link">Schnellzugriff</a>
                            </div>
                        </div>
                        <div class="card border-0 m-2" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Mitarbeiterverwaltung</h5>
                                <a href="../admin/employees.php" class="card-link">Schnellzugriff</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <?php include_once "../services/footer.php"; ?>
</body>

</html>