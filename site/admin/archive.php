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
    <title>AeBo-Web</title>
    <link rel="icon" type="image/x-icon" href="../../assets/svg/favicon.svg">

    <link href=../../assets/vendor/bootstrap/bootstrap.min.css rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style/style.css">
    <!--  Bootstrap -->
    <script src="../../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="../../assets/vendor/jquery/jquery-3.5.1.js"></script>
    <!-- Datatables -->
    <script src="../../assets/vendor/datatables/datatables.min.js"></script>
    <!-- Tables Config -->
    <script src="../../assets/vendor/datatables/tables.js"></script>
    <!--Script-->
    <script src="../../assets/vendor/js/script.js"></script>

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


                $statement = $conn->prepare("SELECT * FROM lib_books where deleted = 1");
                $statement->execute();
                $result = $statement->get_result();
                if ($result->num_rows != 0) {
                    while ($row = $result->fetch_assoc()) {
                        $bookID = $row['bookID'];
                        $book_autor = $row['book_autor'];
                        $book_comment = $row['book_comment'];
                        $book_aditionalinfo = $row['book_aditionalinfo'];
                ?>
                        <tr>
                            <th scope="row"><?php echo $row['book_number'] ?></th>
                            <td><?php echo $row['book_title'] ?></td>
                            <td><?php echo $row['book_autor'] ?></td>
                            <td><?php echo $row['book_edition'] ?></td>
                            <td>
                                <button type="button" class="btn border-0" data-bookID="<?php echo $row['bookID'] ?>" onclick="RestoreModal(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3C140.6 6.8 151.7 0 163.8 0zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm192 64c-6.4 0-12.5 2.5-17 7l-80 80c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V408c0 13.3 10.7 24 24 24s24-10.7 24-24V273.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-4.5-4.5-10.6-7-17-7z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="RestoreModal" tabindex="-1" aria-labelledby="RestoreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="RestoreModalLabel">Wiederherstellen Bestätigen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Wollen sie das Buch wirklich wiederherstellen?
                </div>
                <div class="modal-footer">
                    <form method="post" action="functions.php">
                        <input id="RestoreModalBookID" type="text" hidden name="delete_restoreID" value="">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button class="btn btn-outline-success" type="submit" data-toggle="modal" name="delete_restore">Wiederherstellen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include "../services/footer.php"; ?>
    <script>
        function RestoreModal(entry) {
            $("#RestoreModalBookID").val($(entry).attr("data-bookID"))
            $("#RestoreModal").modal("show");
        }
    </script>


</body>

</html>