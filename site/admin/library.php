<?php
session_start();
include "../../site/services/db_connect.php";

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: ../services/login.php');
    exit;
}

$username = $_SESSION['username'];

$statement = $conn->prepare("SELECT lib_books.*, lib_borrowing.ausleihID, lib_borrowing.zurueckgegeben,lib_borrowing.zugestellt, lib_borrowing.nickname, lib_borrowing.datum, AeBo_employees.first_name, AeBo_employees.last_name FROM lib_books INNER JOIN lib_borrowing ON lib_borrowing.buchID = lib_books.buchID INNER JOIN AeBo_employees ON lib_borrowing.nickname = AeBo_employees.nickname ORDER BY lib_borrowing.ausleihID ASC; ");
$statement->execute();
$result = $statement->get_result();
?>
<!DOCTYPE html>
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
        table.dataTable td {
            white-space: nowrap !important;
            text-overflow: ellipsis !important;
            overflow: hidden !important;
        }
    </style>
</head>

<body>
         <?php     
    $showSearch = false;
    $showEmpDatalist = false;
    include "../services/nav_index.php";
    setnavvalues($showSearch, $showEmpDatalist); ?>

    


    <!-- delivermodal -->
    <div class="modal fade" id="DeliverModal" tabindex="-1" aria-labelledby="DeliverModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="#DeliverModalLabel">Zustellen Bestätigen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Wollen sie das Buch wirklich zustellen?
                </div>
                <div class="modal-footer">
                    <form method="post" action="functions.php">
                    <input type="text" name="buchID" id="#DeliverModal_buchID" hidden value="">
                        <input type="text" name="ausleihID" id="#DeliverModal_ausleihID" hidden value="">
                        <button type="button" class="btn btn-outline-danger border-0" id="decline" data-bs-dismiss="modal">Abbrechen</button>
                        <button class="btn btn-outline-success border-0" type="submit" id="accept" name="deliver">Zustellen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- end delivermodal -->
    <!-- ReturnModal -->
    <div class="modal fade" id="ReturnModal" tabindex="-1" aria-labelledby="ReturnModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ReturnModalLabel">Zustellen Bestätigen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Wurde das Buch wirklich zurückgegeben?
                </div>
                <div class="modal-footer">
                    <form method="post" action="functions.php">
                        <input type="text" name="ausleihID" id="#ReturnModal_ausleihID" hidden value="">
                        <input type="text" name="buchID" id="#ReturnModal_buchID" hidden value="">
                        <button type="button" class="btn btn-outline-danger border-0" id="decline" data-bs-dismiss="modal">Abbrechen</button>
                        <button class="btn btn-outline-success border-0" type="submit" id="accept" name="return">Zurückgeben</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end ReturnModal -->

    <!-- offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="InfoOffcanvas" aria-labelledby="InfoOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="InfoOffcanvasLabel">
                <span id="book_title"></span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <p>Autor:</p>
                <span id="book_autor"></span>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p>Nr:</p>
                    <span id="book_number"></span>
                </div>
                <div class="col-md-4">
                    <p>Ausgabe:</p>
                    <span id="book_edition"></span>
                </div>
                <div class="col-md-4">
                    <p>Bemerkung:</p>
                    <span id="book_comment"></span>
                </div>
            </div>
            <?php
            if ($row['borrowed'] == 1) {
            ?>
                <div class="row">

                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <!-- end offcanvas-->

    <div class="container-fluid">
        <div class="row">
            <div class="col pe-3">
                <div class="card mt-3">
                    <div class="card-header">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 448 512">
                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path d="M429.6 92.1c4.9-11.9 2.1-25.6-7-34.7s-22.8-11.9-34.7-7l-352 144c-14.2 5.8-22.2 20.8-19.3 35.8s16.1 25.8 31.4 25.8H224V432c0 15.3 10.8 28.4 25.8 31.4s30-5.1 35.8-19.3l144-352z" />
                        </svg>
                        Zustellen
                    </div>
                    <div class="card-body">
                        <table id="" class="table">
                            <thead>
                                <tr class="header">
                                    <th scope="col" style="width: 5%"></th>
                                    <th scope="col" style="width: 10%">MA</th>
                                    <th scope="col" style="width: 65%">Buch Titel</th>
                                    <th scope="col" style="width: 10%">Datum</th>
                                    <th scope="col" style="width: 10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows != 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        if ($row['zurueckgegeben'] == 0 & $row['deleted'] == 0 & $row['zugestellt'] == 0) {
                                ?>
                                            <!-- id ist für den index im table js-->
                                            <tr id="<?php echo $row['buchID'] ?>">
                                                <th scope="row">
                                                    <button type="button" class="btn border-0" data-bs-toggle="offcanvas" data-bs-target="#InfoOffcanvas" id="entry<?php echo $row['buchID']; ?>" aria-controls="InfoOffcanvas" data-id="entry<?php echo $row['buchID']; ?>" data-bookdata='<?php echo $row['buchID']; ?> # <?php echo $row['book_title']; ?> # <?php echo $row['book_autor']; ?> # <?php echo $row['book_edition']; ?> # <?php echo $row['book_comment']; ?> # <?php echo $row['book_aditionalinfo']; ?> # <?php echo $row['book_number']; ?>' onclick=InfoOffcanvas(this)>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 192 512">
                                                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path d="M144 80c0 26.5-21.5 48-48 48s-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z" />
                                                        </svg>
                                                    </button>
                                                </th>
                                                <td><img class="rounded-circle shadow-sm" alt="MA" src="../../assets/images/employees_200px/<?php echo $row['nickname']; ?>" style="height: 50px;" data-bs-toggle="tooltip" data-bs-title="<?php echo $row['nickname']; ?>"></td>
                                                <td><?php echo $row['book_title'] ?></td>
                                                <td><?php echo date("d/m/Y", strtotime($row['datum'])); ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-secondary border-0" data-id="<?php echo $row['ausleihID']; ?>" data-target="#DeliverModal" onclick="OpenModal(this)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 448 512">
                                                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path d="M429.6 92.1c4.9-11.9 2.1-25.6-7-34.7s-22.8-11.9-34.7-7l-352 144c-14.2 5.8-22.2 20.8-19.3 35.8s16.1 25.8 31.4 25.8H224V432c0 15.3 10.8 28.4 25.8 31.4s30-5.1 35.8-19.3l144-352z" />
                                                        </svg>
                                                    </button>


                                                </td>
                                            </tr>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col ps-0">
                <div class="card mt-3">
                    <div class="card-header">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 512 512">
                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path d="M125.7 160H176c17.7 0 32 14.3 32 32s-14.3 32-32 32H48c-17.7 0-32-14.3-32-32V64c0-17.7 14.3-32 32-32s32 14.3 32 32v51.2L97.6 97.6c87.5-87.5 229.3-87.5 316.8 0s87.5 229.3 0 316.8s-229.3 87.5-316.8 0c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0c62.5 62.5 163.8 62.5 226.3 0s62.5-163.8 0-226.3s-163.8-62.5-226.3 0L125.7 160z" />
                        </svg>
                        Zurücknehmen
                    </div>

                    <div class="card-body flex-fill">
                        <table id="" class="table">
                            <thead>
                                <tr class="header">
                                    <th scope="col" style="width: 5%"></th>
                                    <th scope="col" style="width: 10%">MA</th>
                                    <th scope="col" style="width: 65%">Buch Titel</th>
                                    <th scope="col" style="width: 10%">Datum</th>
                                    <th scope="col" style="width: 10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $statement = $conn->prepare("SELECT lib_books.*, lib_borrowing.ausleihID, lib_borrowing.zurueckgegeben,lib_borrowing.zugestellt, lib_borrowing.nickname, lib_borrowing.datum, AeBo_employees.nickname FROM lib_books INNER JOIN lib_borrowing ON lib_borrowing.buchID = lib_books.buchID INNER JOIN AeBo_employees ON lib_borrowing.nickname = AeBo_employees.nickname ORDER BY lib_borrowing.ausleihID ASC; ");
                                $statement->execute();
                                $result = $statement->get_result();
                                if ($result->num_rows != 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        if ($row['zurueckgegeben'] == 0 & $row['deleted'] == 0 & $row['zugestellt'] == 1) {
                                ?>
                                            <!-- id ist für den index im table js-->
                                            <tr id="<?php echo $row['buchID'] ?>">
                                                <th scope="row">
                                                    <button type="button" class="btn border-0" data-bs-toggle="offcanvas" data-bs-target="#InfoOffcanvas" id="entry<?php echo $row['buchID']; ?>" aria-controls="InfoOffcanvas" data-id="entry<?php echo $row['buchID']; ?>" data-bookdata='<?php echo $row['buchID']; ?> # <?php echo $row['book_title']; ?> # <?php echo $row['book_autor']; ?> # <?php echo $row['book_edition']; ?> # <?php echo $row['book_comment']; ?> # <?php echo $row['book_aditionalinfo']; ?> # <?php echo $row['book_number']; ?>' onclick=InfoOffcanvas(this)>

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 192 512">
                                                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path d="M144 80c0 26.5-21.5 48-48 48s-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z" />
                                                        </svg>
                                                    </button>
                                                </th>
                                                <td><img class="rounded-circle shadow-sm" alt="MA" src="../../assets/images/employees_200px/<?php echo $row['nickname']; ?>.png" style="height: 50px;" data-bs-toggle="tooltip" data-bs-title="<?php echo $row['nickname']; ?>"></td>
                                                <td><?php echo $row['book_title'] ?></td>
                                                <td><?php echo date("d/m/Y", strtotime($row['datum'])); ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-secondary border-0" data-id="<?php echo $row['ausleihID']; ?>" data-bookID="<?php echo $row['buchID']; ?>" data-target="#ReturnModal" onclick="OpenModal(this)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 512 512">
                                                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path d="M125.7 160H176c17.7 0 32 14.3 32 32s-14.3 32-32 32H48c-17.7 0-32-14.3-32-32V64c0-17.7 14.3-32 32-32s32 14.3 32 32v51.2L97.6 97.6c87.5-87.5 229.3-87.5 316.8 0s87.5 229.3 0 316.8s-229.3 87.5-316.8 0c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0c62.5 62.5 163.8 62.5 226.3 0s62.5-163.8 0-226.3s-163.8-62.5-226.3 0L125.7 160z" />
                                                        </svg>
                                                    </button>


                                                </td>
                                            </tr>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!--  Start neues buch info toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="book_order_toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header " style="color: #ce0145;">
                <span class="me-2">
                    <svg width="16" height="16" fill="currentColor" class="bi bi-exclamation-square" viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
                    </svg>
                </span>
                <strong class="me-auto ml-2">Buchbestellung</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <a href="../admin/order_book_admin.php" class="link-dark">Es wurden neue Bücher bestellt.</a>
            </div>
        </div>
    </div>
    <!--  ende neues buch info toast -->

    <?php include_once "../services/footer.php"; ?>


    <!--  Bootstrap -->
    <script src="../../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="../../assets/vendor/jquery/jquery-3.5.1.js"></script>
    <!-- Datatables-->
    <script src="../../assets/vendor/datatables/datatables.min.js"></script>
    <!-- Ellipsis-->
    <script src="../../assets/vendor/datatables/ellipsis.js"></script>
    <!-- Sidebar-->
    <script src="../../assets/vendor/js/sidebars.js"></script>

    <?php
    $statement = $conn->prepare('SELECT bestellungID FROM lib_book_orders WHERE bestellung_status = 0');
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows == 0) {
    } else {
        echo '
        <script>
            const toastLiveExample = document.getElementById("book_order_toast")
            const toast = new bootstrap.Toast(toastLiveExample)
            toast.show()
        </script>
      ';
    }

    ?>
    <script>
        $(document).ready(function() {
            $('table.table').DataTable({
                "bFilter": false,
                "bLengthChange": false,
                "info": false,
                "scrollY": "770px",
                "pageLength": 5,
                "language": {
                    "paginate": {
                        "previous": "Zurück",
                        "next": "Weiter"
                    }
                }
            });
        });

        $(document).ready(function() {


            $('#datatable').DataTable({
                "bLengthChange": false,
                "info": false,


                "language": {
                    zeroRecords: "Es wurden keine Bücher gefunden...",
                    "paginate": {
                        "previous": "Zurück",
                        "next": "Weiter"
                    }
                }

            });


        });

        $(window).on("load", function() {
            $(".loader-wrapper").fadeOut("slow");
        });
    </script>

    <script>
        function InfoOffcanvas(entry) {
            const bookdata = entry.getAttribute("data-bookdata").split('#');
            const Booknummer = bookdata[0];
            document.getElementById("book_title").innerHTML = bookdata[1];
            document.getElementById("book_autor").innerHTML = bookdata[2];
            document.getElementById("book_edition").innerHTML = bookdata[3];
            document.getElementById("book_comment").innerHTML = bookdata[4];
            //document.getElementById("book_aditionalinfo").innerHTML = bookdata[5];
            document.getElementById("book_number").innerHTML = bookdata[6];
            var profileimg = document.createElement("img");
            profileimg.src = "../../assets/images/" + Booknummer + ".jpg";
            profileimg.width = "75";
            console.log(bookdata)
        }
    </script>

    <script>
        function OpenModal(entry) {
            var id = entry.getAttribute("data-id");
            var BookID = entry.getAttribute("data-bookID");
            var target = entry.getAttribute("data-target");
            $(target).modal("show");

            console.log(target);
            //macht id in hidden input in delete modal
            document.getElementById(target + "_ausleihID").setAttribute('value', id);
            document.getElementById(target + "_buchID").setAttribute('value', BookID);
            //zeigt name in span element mit id employeename
            //document.getElementById("BookNumber").innerHTML = BookNumber;
        }
    </script>
</body>

</html>