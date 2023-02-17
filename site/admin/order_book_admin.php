<?php
session_start();

$username = $_SESSION["username"];

 

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../services/login.php");
    exit;
}

if (session_id() == '') {
    session_start();
}

$launchmodal = 0
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

    <style>
        th:nth-child(1) {
            text-align: right;
        }

        td:nth-child(1) {
            text-align: right;
        }
    </style>
</head>

<body>
         <?php     
    $showSearch = false;
    $showEmpDatalist = false;
    include "../services/nav_index.php";
    setnavvalues($showSearch, $showEmpDatalist); ?>


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
                            <th scope="col" style="width: 5%">Bestelldatum</th>
                            <th scope="col" style="width: 10%">Titel</th>
                            <th scope="col" style="width: 65%">Besteller</th>
                            <th scope="col" style="width: 10%">Info</th>
                            <th scope="col" style="width: 10%">Bestellt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../../site/services/db_connect.php";


                        $statement = $conn->prepare("SELECT * from lib_book_orders");
                        $statement->execute();
                        $result = $statement->get_result();
                        $nummer = 1;
                        if ($result->num_rows != 0) {
                            while ($row = $result->fetch_assoc()) {
                                $bestellungID = $row['bestellungID'];
                                $bestellung_autor = $row['bestellung_autor'];
                                $bestellung_titel = $row['bestellung_titel'];
                                $bestellung_ausgabe = $row['bestellung_ausgabe'];
                                $bestellung_isbn = $row['bestellung_isbn'];
                                $bestellung_bemerkung = $row['bestellung_bemerkung'];
                                $bestellung_bestellername = $row['bestellung_bestellername'];
                                $bestellung_datum = $row['bestellung_datum'];
                                $bestellung_status = $row['bestellung_status'];

                                if ($bestellung_status == 0) {
                                    echo
                                    '
                            <tr>
                            <th scope="row">' . $bestellung_datum . '</th>
                            <td>' . $bestellung_titel . '</td>
                            <td>' . $bestellung_bestellername . '</td>
                            
                            <td>
                                <button  
                                    class="btn btn-outline-none" 
                                    type="button" data-bs-toggle="offcanvas" 
                                    data-bs-target="#offcanvasExample' . $nummer . '" 
                                    aria-controls="offcanvasExample' . $nummer . '">
                                        <img src="../../assets/images/icons/info-circle.svg" class="img-fluid" >
                                </button>
                            </td>

                            <td>
                                <button type="button" class="btn btn-outline-none" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <img src="../../assets/images/icons/check.svg" class="img-fluid" >
                                </button>                            
                            </td>

                            </tr>

                              <!-- Offcanvas -->
                                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample' . $nummer . '" aria-labelledby="offcanvasExampleLabel">
                                    <div class="offcanvas-header text-center">
                                        <h3 class="offcanvas-title" id="offcanvasExampleLabel">Buchbestellung</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body">

                                    <div class="container border rounded">
                                    <div class="row">
                                        <div class="col border-bottom">
                                        <h3>
                                        ' . $bestellung_titel . '
                                        <h3>
                                        </div>
                                    </div>
                                    <div class="row border-bottom">
                                        <div class="col">
                                        <h4>Autor</h4>
                                        <p>
                                        ' . $bestellung_autor . '
                                        </p>
                                        </div>
                                        <div class="col">
                                        <h4>Ausgabe</h4>
                                        <p>
                                        ' . $bestellung_ausgabe . '
                                        </p>
                                        </div>
                                    </div>
                                    <div class="row border-bottom">
                                        <div class="col">
                                        <h4>ISBN</h4>
                                        <p>
                                        ' . $bestellung_isbn . '
                                        </p>
                                        </div>
                                    </div>
                                    <div class="row border-bottom">
                                        <div class="col">
                                        <h4>Bemerkung</h4>
                                        <p>
                                        ' . $bestellung_bemerkung . '
                                        </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col ">
                                        <h4>Besteller</h4>
                                        <p>
                                        ' . $bestellung_bestellername . '
                                        </p>
                                        </div>
                                        <div class="col">
                                        <h4>Datum</h4>
                                        <p>
                                        ' . $bestellung_datum . '
                                        </p>
                                        </div>
                                    </div>
                                </div>
                                        
                                     </div>
                                </div>


                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Bestellung Bestätigen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Haben sie das Buch wirklich bestellt?
                                        </div>
                                        <div class="modal-footer">
                                            <form method="post" action="functions.php">
                                                <input type="text" hidden name="orderedID" value="' . $bestellungID . '">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Abbrechen</button>
                                                <button class="btn btn-outline-success" type="submit" data-toggle="modal" name="ordered">Bestellt</button>
                                            </form>                                              
                                    </div>
                                    </div>
                                </div>
                            </div>
                            ';
                                    $nummer++;
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