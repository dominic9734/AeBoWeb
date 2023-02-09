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