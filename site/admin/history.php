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
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AEBO-Library</title>
    <link rel="icon" type="image/x-icon" href="../../assets/svg/favicon.svg">

    <link href=../../assets/vendor/bootstrap/bootstrap.min.css rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style/style.css">

</head>

<body>
    <?php include "../services/nav.php"; ?>

    <div class="container-fluid">
        <div class="card mt-3">
            <div class="card-header">
                <div class="input-group my-2">
                    <span class="input-group-text" id="basic-addon1"> <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 512 512">
                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352c79.5 0 144-64.5 144-144s-64.5-144-144-144S64 128.5 64 208s64.5 144 144 144z" />
                        </svg></span>
                    <label for="txtSearch"></label><input id="txtSearch" placeholder="Buch suchen..." class="form-control" />
                </div>
            </div>

            <div class="card-body">
                <table id="datatable" class="table">
                    <thead>
                        <tr class="header">
                            <th scope="col" style="width: 5%">#</th>
                            <th scope="col" style="width: 10%">Besitzer</th>
                            <th scope="col" style="width: 65%">Titel</th>
                            <th scope="col" style="width: 20%">Von / Bis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../../site/services/db_connect.php";


                        $statement = $conn->prepare("SELECT * from lib_borrowing LEFT JOIN lib_books ON lib_borrowing.buchID = lib_books.buchID;");
                        $statement->execute();
                        $result = $statement->get_result();
                        if ($result->num_rows != 0) {
                            while ($row = $result->fetch_assoc()) {
                                $ausleihID = $row['ausleihID'];
                                $datum = $row['datum'];
                                $rueckgabe_datum = $row['rueckgabe_datum'];
                                $nickname = $row['nickname'];
                                $zurueckgegeben = $row['zurueckgegeben'];
                                $buch_titel = $row['buch_titel'];
                                $buch_nummer  = $row['buch_nummer'];
                                $nickname = $row['nickname'];

                                if ($zurueckgegeben == 1) {
                                    echo
                                    '
                            <tr>
                            <th scope="row">' . $buch_nummer . '</th>
                            <td>' . $nickname . '</td>
                            <td>' . $buch_titel . '</td>
                            <td>' . $datum . ' / ' . $rueckgabe_datum . '</td>
                            </tr>
                            ';
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include "../services/footer.php"; ?>

    <!--  Bootstrap -->
    <script src="../../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="../../assets/vendor/jquery/jquery-3.5.1.js"></script>
    <!-- Datatables -->
    <script src="../../assets/vendor/datatables/datatables.min.js"></script>
    <!-- Tables Config -->
    <script src="../../assets/vendor/datatables/tables.js"></script>
    <!--Loading screen-->
    <script src="../../assets/vendor/js/loading.js"></script>


</body>

</html>