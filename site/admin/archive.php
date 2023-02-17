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
<div class="loader_wrapper">
        <div class="spinner-border" role="status">
        </div>
    </div>
    <?php
    $showSearch = True;
    include "../services/nav.php"; ?>

    <div class="container-fluid">

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


                $statement = $conn->prepare("SELECT * FROM lib_books");
                $statement->execute();
                $result = $statement->get_result();
                if ($result->num_rows != 0) {
                    while ($row = $result->fetch_assoc()) {
                        $buchID = $row['buchID'];
                        $book_number = $row['book_number'];
                        $book_title = $row['book_title'];
                        $book_autor = $row['book_autor'];
                        $book_edition = $row['book_edition'];
                        $book_comment = $row['book_comment'];
                        $book_aditionalinfo = $row['book_aditionalinfo'];
                        $ausleihID = $row['borrowed'];
                        $deleted = $row['deleted'];
                        if ($deleted == 1) {
                            echo
                            '
                            <tr>
                            <th scope="row">' . $book_number . '</th>
                            <td>' . $book_title . '</td>
                            <td>' . $book_autor . '</td>
                            <td>' . $book_edition . '</td>
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
    <!--Script-->
    <script src="../../assets/vendor/js/script.js"></script>


</body>

</html>