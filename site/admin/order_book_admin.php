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
    <?php
    $showSearch = true;
    $showEmpDatalist = false;
    include "../services/nav.php";
    setnavvalues($showSearch, $showEmpDatalist); ?>

    <div class="container-fluid">
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
                $statement = $conn->prepare("SELECT lib_book_orders.*,aebo_employees.first_name,aebo_employees.last_name from lib_book_orders LEFT JOIN aebo_employees on lib_book_orders.order_employeeID = aebo_employees.employeeID WHERE order_status = 0");
                $statement->execute();
                $result = $statement->get_result();
                if ($result->num_rows != 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo
                        '
                            <tr>
                            <th scope="row">' . $row['order_date'] . '</th>
                            <td>' . $row['book_title'] . '</td>
                            <td>' . $row['first_name'] . " " . $row['last_name'] . '</td>
                            
                            <td>
                                <button  
                                data-order="
                                [&#34;' . $row['orderID'] . '&#34;, &#34;' . $row['book_title'] . '&#34;, &#34;' . $row['book_autor'] . '&#34;, &#34;' . $row['book_edition'] . '&#34;, &#34;' . $row['book_isbn'] . '&#34;, &#34;' . $row['order_comment'] . '&#34;, &#34;' . $row['first_name'] . " " . $row['last_name'] . '&#34;, &#34;' . $row['order_date'] . '&#34;]
                                "
                                    class="btn border-0" 
                                    onclick="OrderModal(this)"
                                    >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 192 512">
                                    <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path d="M144 80c0 26.5-21.5 48-48 48s-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z" />
                                </svg>
                                </button>
                            </td>

                            <td>
                            
                                <button type="button" class="btn border-0" data-orderID="' . $row['orderID'] . '" data-title="' . $row['book_title'] . '" onclick="ConfirmOrder(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512" style="display: inline-block ;">
                                <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                            </svg>
                                </button>                            
                            </td>

                            </tr>             
                            ';
                    }
                }

                ?>
            </tbody>
        </table>
    </div>
    <div class="modal" id="ConfirmOrder" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bestellen Abgeschlossen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Das Buch <span id="Book_title_display"></span> wurde bestellt!</p>
                </div>
                <div class="modal-footer">
                    <form action="functions.php" method="post">
                        <input id="ConfirmOrderID" name="orderID" type="text" value="" hidden>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button type="submit" name="ordered" class="btn btn-primary">Bestätigen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="OrderModal" tabindex="-1" aria-labelledby="OrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex">
                    <strong class="modal-title fs-5 flex-grow-1" id="exampleModalLabel">Buchbespellung von <span id="input_order_employee"> </span></strong> <small class="mx-2"><span id="input_order_date"></span></small>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="row mt-3">
                        <div class="col">
                            <div class="combobox">
                                <input type="text" value="" id="input_book_title" readonly>
                                <button class="CopyToClipboard_btn" onclick="CopyToClipboard(this)" data-bs-toggle="tooltip" data-bs-title="Kopieren">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path d="M280 64h40c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128C0 92.7 28.7 64 64 64h40 9.6C121 27.5 153.3 0 192 0s71 27.5 78.4 64H280zM64 112c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V128c0-8.8-7.2-16-16-16H304v24c0 13.3-10.7 24-24 24H192 104c-13.3 0-24-10.7-24-24V112H64zm128-8a24 24 0 1 0 0-48 24 24 0 1 0 0 48z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="combobox">
                                <input type="text" value="" id="input_book_autor" readonly>
                                <button class="CopyToClipboard_btn" onclick="CopyToClipboard(this)" data-bs-toggle="tooltip" data-bs-title="Kopieren">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path d="M280 64h40c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128C0 92.7 28.7 64 64 64h40 9.6C121 27.5 153.3 0 192 0s71 27.5 78.4 64H280zM64 112c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V128c0-8.8-7.2-16-16-16H304v24c0 13.3-10.7 24-24 24H192 104c-13.3 0-24-10.7-24-24V112H64zm128-8a24 24 0 1 0 0-48 24 24 0 1 0 0 48z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="combobox">
                                <input type="text" value="" id="input_book_edition" readonly>
                                <button class="CopyToClipboard_btn" onclick="CopyToClipboard(this)" data-bs-toggle="tooltip" data-bs-title="Kopieren">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path d="M280 64h40c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128C0 92.7 28.7 64 64 64h40 9.6C121 27.5 153.3 0 192 0s71 27.5 78.4 64H280zM64 112c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V128c0-8.8-7.2-16-16-16H304v24c0 13.3-10.7 24-24 24H192 104c-13.3 0-24-10.7-24-24V112H64zm128-8a24 24 0 1 0 0-48 24 24 0 1 0 0 48z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="combobox">
                                <input type="text" data-val="" value="" id="input_book_isbn" readonly>
                                <button class="CopyToClipboard_btn" onclick="CopyToClipboard(this)" data-bs-toggle="tooltip" data-bs-title="Kopieren">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path d="M280 64h40c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128C0 92.7 28.7 64 64 64h40 9.6C121 27.5 153.3 0 192 0s71 27.5 78.4 64H280zM64 112c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V128c0-8.8-7.2-16-16-16H304v24c0 13.3-10.7 24-24 24H192 104c-13.3 0-24-10.7-24-24V112H64zm128-8a24 24 0 1 0 0-48 24 24 0 1 0 0 48z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="combobox">
                                <input type="text" value="" id="input_order_comment" readonly>
                                <button class="CopyToClipboard_btn" onclick="CopyToClipboard()" data-bs-toggle="tooltip" data-bs-title="Kopieren">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path d="M280 64h40c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128C0 92.7 28.7 64 64 64h40 9.6C121 27.5 153.3 0 192 0s71 27.5 78.4 64H280zM64 112c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V128c0-8.8-7.2-16-16-16H304v24c0 13.3-10.7 24-24 24H192 104c-13.3 0-24-10.7-24-24V112H64zm128-8a24 24 0 1 0 0-48 24 24 0 1 0 0 48z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Schliessen</button>
                </div>
            </div>
        </div>
    </div>
    <?php include "../services/footer.php"; ?>
    <script>
        function OrderModal(entry) {
            var data = JSON.parse($(entry).attr("data-order"))
            const OrderModal = document.getElementById('OrderModal')
            $("#input_book_title").val(data[1]);
            $("#input_book_autor").val(data[2]);
            $("#input_book_edition").val(data[3]);
            $("#input_book_isbn").val(data[4]);
            $("#input_order_comment").val(data[5]);
            $("#input_order_employee").html(data[6]);
            $("#input_order_date").html(data[7]);
            $("#OrderModal").modal("show")

        }

        function ConfirmOrder(entry) {
            $("#ConfirmOrderID").val($(entry).attr("data-orderID"));
            $("#Book_title_display").text($(entry).attr("data-title"));
            $("#ConfirmOrder").modal("show")

        }

        function CopyToClipboard(input) {
            // Get the text field
            var copyText = $(input).parent().children().first();
            // Select the text field
            copyText.select();
            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.val());
        }
    </script>

</body>

</html>