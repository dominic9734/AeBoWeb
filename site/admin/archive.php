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
                    <label for="filterInput"></label><input type="text" class="form-control" placeholder="Titel, Autor suchen" id="filterInput" onkeyup="filtern()">
                </div>
            </div>

            <div class="card-body">
                <table id="datatable" class="table">
                    <thead>
                        <tr class="header">
                            <th scope="col" style="width: 5%">#</th>
                            <th scope="col" style="width: 65%">Titel</th>
                            <th scope="col" style="width: 20%">Autor</th>
                            <th scope="col" style="width: 5%">Ausgabe</th>
                            <th scope="col" style="width: 5%">Wiederherstellen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../../site/services/db_connect.php";


                        $statement = $conn->prepare("SELECT * FROM lib_books");
                        $statement->execute();
                        $result = $statement->get_result();
                        if ($result->num_rows != 0) {
                            while ($row = $result->fetch_assoc()) {
                                $buchID = $row['buchID'];
                                $buch_nummer = $row['buch_nummer'];
                                $buch_titel = $row['buch_titel'];
                                $buch_autor = $row['buch_autor'];
                                $buch_ausgabe = $row['buch_ausgabe'];
                                $buch_bemerkung = $row['buch_bemerkung'];
                                $buch_kurzbeschrieb = $row['buch_kurzbeschrieb'];
                                $ausleihID = $row['ausgeliehen'];
                                $geloescht = $row['geloescht'];
                                if ($geloescht == 1) {
                                    echo
                                    '
                            <tr>
                            <th scope="row">' . $buch_nummer . '</th>
                            <td>' . $buch_titel . '</td>
                            <td>' . $buch_autor . '</td>
                            <td>' . $buch_ausgabe . '</td>
                            <td>
                                <button type="button" class="btn btn-outline-none" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <img src="../../assets/images/icons/arrow-repeat.svg" class="img-fluid" >
                                </button>
                            </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Wiederherstellen Bestätigen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Wollen sie das Buch wirklich wiederherstellen?
                                        </div>
                                        <div class="modal-footer">
                                            <form method="post" action="functions.php">
                                                <input type="text" hidden name="delete_restoreID" value="' . $buchID . '">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Abbrechen</button>
                                                <button class="btn btn-outline-success" type="submit" data-toggle="modal" name="delete_restore">Wiederherstellen</button>
                                            </form>                                      
                                        </div>
                                    </div>
                                </div>
                            </div>
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