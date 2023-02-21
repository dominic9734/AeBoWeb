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
    <?php
    $showSearch = True;
    include "../services/nav.php"; ?>

    <div class="container-fluid">

        <table id="datatable" class="table">
            <thead>
                <tr class="header">
                    <th scope="col" style="width: 5%">#</th>
                    <th scope="col" class=" table-align-left" style="width: 65%">Titel</th>
                    <th scope="col" class=" table-align-right" style="width: 10%">MA</th>
                    <th scope="col" style="width: 20%">Von / Bis</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "../../site/services/db_connect.php";


                $statement = $conn->prepare("SELECT first_name,last_name,taken_date,returned_date,book_title,book_number FROM `junction_books` LEFT JOIN aebo_employees ON junction_books.employeeID = aebo_employees.employeeID LEFT JOIN lib_books ON junction_books.bookID = lib_books.bookID WHERE returned = 1");
                $statement->execute();
                $result = $statement->get_result();
                if ($result->num_rows != 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo
                        '
                            <tr>
                            <th scope="row">' . $row['book_number'] . '</th>
                            <td class=" table-align-left">' . $row['book_title'] . '</td>
                            <td class=" table-align-right">' . $row['first_name'] . " " . $row['last_name'] . '</td>
                            <td>' . $row['taken_date'] . ' / ' . $row['returned_date'] . '</td>
                            </tr>
                            ';
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


</body>

</html>