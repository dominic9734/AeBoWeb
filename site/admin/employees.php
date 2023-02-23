<?php
session_start();

$username = $_SESSION["username"];

$admin = true;

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../services/login.php");
    exit;
}

if (session_id() == '') {
    session_start();
}

if (isset($_POST["submit"])) {
    $check_employee = $conn->prepare("SELECT nickname FROM AeBo_employees WHERE nickname = ?");
    $check_employee->bind_param("s", $nickname);
    $check_employee->execute();
    $result = $check_employee->get_result();

    if ($result->num_rows > 0) {
        // Employee already exists, do not execute INSERT statement
        echo "Employee already exists";
    } else {
        // Employee does not exist, execute INSERT statement
        $statement = $conn->prepare("INSERT INTO AeBo_employees (nickname, nickname) VALUES(?,?)");
        $statement->bind_param("ss", $nickname, $nickname);
        $statement->execute();
        header("location:employees.php");
        exit();
    }
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
    $showSearch = True;
    include "../services/nav.php";
    ?>

    <!-- Loading screen -->
    <div class="loader_wrapper">
        <div class="spinner-border" role="status">
        </div>
    </div>
    <!-- End Loading screen -->

    <!-- Erstellen Modal -->
    <div class="modal fade" id="AddEmployeeModal" tabindex="-1" aria-labelledby="AddEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form method="post" action="functions.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <h3 class="my-3">Personalangaben</h3>
                        <div class="row ms-1 ">
                            <div class="col-1">
                                <h4 class="text-start">Name</h4>
                            </div>
                            <div class="col col-4">
                                <input type="text" class="form-control" name="first_name_input" id="first_name_input" placeholder="Hans" required>
                            </div>
                            <div class="col col-4">
                                <input type="text" class="form-control" name="last_name_input" id="last_name_input" placeholder="Peter" required>
                            </div>
                            <div class="col col-3">
                                <input type="text" class="form-control" name="nickname_input" id="nickname_input" placeholder="HPe" required>
                            </div>
                        </div>
                        <div class="row ms-1  mt-2">
                            <div class="col-1">
                                <h4 class="text-start">Mail</h4>
                            </div>
                            <div class="col">
                                <input type="email" class="form-control" name="primary_mail_input" id="mail_input" placeholder="h.peter@aebo.ch" required>
                            </div>
                        </div>
                        <div class="row ms-1  my-2">
                            <div class="col-1">
                                <h4 class="text-start">Phone</h4>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="internal_phone_input" id="internal_phone_input" placeholder="Interne Nummer (xxx)">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="mobile_phone_input" id="mobile_phone_input" placeholder="Private Nummer (xxx-xxx-xx-xx)">
                            </div>
                        </div>
                        <h3 class="my-3 text-start">Arbeitsangaben</h3>
                        <div class="row ms-1  mb-2">
                            <div class="col-1">
                                <h4 class="text-start">Arbeit</h4>
                            </div>
                            <div class="col-3">
                                <select class="form-select" aria-label="work_division_input" name="work_division_input" id="work_division_input" required>
                                    <option value="" selected>Abteilung</option>
                                    <option value="ZD">ZD</option>
                                    <option value="IB">IB</option>
                                    <option value="BB">BB</option>
                                    <option value="PB">PB</option>
                                    <option value="TB">TB</option>
                                    <option value="BS">BS</option>
                                    <option value="BG">BG</option>
                                    <option value="VU">VU</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" name="department_input" id="department_input" placeholder="Administration Zentrale Dienste">
                            </div>
                            <div class="col col-4">
                                <input type="text" class="form-control" name="special_authority_input" id="special_authority_input" placeholder="Handlungsbevollmächtigter">
                            </div>
                        </div>
                        <div class="row ms-1  mt-2">
                            <div class="col-1">
                                <h4 class="text-start">Platz</h4>
                            </div>
                            <div class="col">
                                <select class="form-select" aria-label="location_input" name="location_input" id="location_input" required>
                                    <option value="" selected>Stockwerk</option>
                                    <option value="3">3. OG</option>
                                    <option value="4">4. OG</option>
                                    <option value="5">5 .OG</option>
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select" aria-label="zone_input" name="zone_input" id="zone_input" required>
                                    <option value="" selected>Zone</option>
                                    <option value="A">Zone A</option>
                                    <option value="B">Zone B</option>
                                    <option value="C">Zone C</option>
                                    <option value="D">Zone D</option>
                                    <option value="E">Zone E</option>
                                    <option value="F">Zone F</option>
                                </select>
                            </div>
                        </div>
                        <div class="row ms-1  mt-2">
                            <div class="col-1">
                                <h4 class="text-start">Bild</h4>
                            </div>
                            <div class="col">
                                <input class="form-control" type="file" name="employeeimage" accept=".png" id="employeeimage">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger border-0" id="decline" data-bs-toggle="modal">Abbrechen</button>
                        <button type="submit" class="btn btn-outline-success border-0" id="accept" name="CreateEmployee">Hinzufügen</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- CSV optionen Modal -->
    <div class="modal fade" id="EmployeeCSV" tabindex="-1" aria-labelledby="EmployeeCSVLabel" aria-hidden="true">
        <div class="modal-dialog modal modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EmployeeCSVLabel">
                        Mitarbeiter-CSV
                    </h5>
                    <button type="button" class="btn-close" data-bs-toggle="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <form method="post" action="functions.php" enctype="multipart/form-data" accept-charset="utf-8">
                        <div class="mb-3">
                            <p>Export MA</p>
                            <div class="input-group mb-3">
                                <a href='functions.php?ExportCSV=true' class="btn border border-secondary" type="button" id="button-addon1">Download</a>
                                <input type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" value="<?php echo "Export_MA_AEBOLIB_" . date('Y-m-d') . ".csv" ?>">
                            </div>
                        </div>
                        <hr style="margin:0px -20px 10px -20px" />
                        <p>Import MA</p>
                        <div class="mb-3">
                            <input class="form-control" id="CSVUpload" type="file" name="file" accept=".csv" required>
                        </div>
                        <div class="mb-1">
                            <button type="button" class="btn btn-outline-danger border-0" id="decline" data-bs-toggle="modal">Abbrechen</button>
                            <button type="submit" class="btn btn-outline-success border-0" id="accept" name="ImportCSV">Speichern</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Löschen Modal -->
    <div class="modal fade" id="DeleteEmployeeModal" tabindex="-1" aria-labelledby="DeleteEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DeleteEmployeeModal">Löschen Bestätigen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Wollen Sie <span id="EmployeeName"></span> wirklich Löschen
                </div>
                <div class="modal-footer">
                    <form method="post" action="functions.php">
                        <input type="text" hidden id="DelEmployeeID" name="DelEmployeeID" value="">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button class="btn btn-outline-danger" type="submit" data-toggle="modal" name="EmployeeDelete">Löschen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Image Edit Modal -->
    <div class="modal fade" id="UpdateImage" tabindex="-1" aria-labelledby="DUpdateImageLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UpdateImage">Bild ändern</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="updatepfp" src="" alt="Kein Profilbild">
                    <div class="mb-3">
                        <form enctype="multipart/form-data">
                            <input type="text" hidden id="DelEmployeeID" name="DelEmployeeID" value="">
                            <label for="formFile" class="form-label">Neues Profilbild</label>
                            <input class="form-control" type="file" accept=".png" id="employeeimageupdate" name="employeeimageupdate">
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <button class="btn btn-outline-success" type="button" data-toggle="modal" id="submitupdateimage">Speichern</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid p-3 min-vh-100">
        <table id="datatable" class="table">
            <thead>
                <tr class="header">
                    <th scope="col" style="width: 5%">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#AddEmployeeModal" style="display:  inline-block;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox=" 0 0 640 512">
                                <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path d="M352 128c0 70.7-57.3 128-128 128s-128-57.3-128-128S153.3 0 224 0s128 57.3 128 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                            </svg>
                        </button>
                    </th>
                    <th scope="col">Name</th>
                    <th scope="col">Krz.</th>
                    <th scope="col">Bereich</th>
                    <th scope="col">T.-Intern</th>
                    <th scope="col">T.-Extern</th>
                    <th scope="col">Mail</th>
                    <th scope="col">Vollmacht</th>
                    <th scope="col">Abteilung</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Zone</th>
                    <th scope="col">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#EmployeeCSV" style="display:  inline-block;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 512 512">
                                <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336c44.2 0 80-35.8 80-80s-35.8-80-80-80s-80 35.8-80 80s35.8 80 80 80z" />
                            </svg>
                        </button>
                    </th>
                </tr>
            </thead>

            <tbody>
                <?php
                include "../../site/services/db_connect.php";
                $statement = $conn->prepare("SELECT * from AeBo_employees");
                $statement->execute();
                $result = $statement->get_result();
                if ($result->num_rows != 0) {
                    while ($employee = mysqli_fetch_assoc($result)) { ?>
                        <tr id="row<?php echo $employee['employeeID']; ?>">
                            <th scope="row"><img class="rounded-circle shadow-sm updateimage" alt="MA" src="../../assets/images/employees_200px/<?php echo $employee['employee_image']; ?>" style="height: 50px;" data-id="<?php echo $employee['employeeID']; ?>" onclick="EditImage(this)"></th>
                            <td class="editable" id="name<?php echo $employee['employeeID']; ?>" contenteditable="false"><?php echo $employee['first_name'] . " " . $employee['last_name']; ?></td>
                            <td class="editable" id="nickname<?php echo $employee['employeeID']; ?>" contenteditable="false"><?php echo $employee['nickname']; ?></td>

                            <td class="editable" id="work_division<?php echo $employee['employeeID']; ?>" contenteditable="false"><?php echo $employee['work_division']; ?></td>

                            <td class="editable" id="internal_phone<?php echo $employee['employeeID']; ?>" contenteditable="false"><?php echo $employee['internal_phone']; ?></td>

                            <td class="editable" id="mobile_phone<?php echo $employee['employeeID']; ?>" contenteditable="false"><?php echo $employee['mobile_phone']; ?></td>

                            <td class="editable" id="primary_mail<?php echo $employee['employeeID']; ?>" contenteditable="false"><?php echo $employee['primary_mail']; ?></td>

                            <td class="editable" id="special_authority<?php echo $employee['employeeID']; ?>" contenteditable="false"><?php echo $employee['special_authority']; ?></td>

                            <td class="editable" id="department<?php echo $employee['employeeID']; ?>" contenteditable="false"><?php echo $employee['department']; ?></td>

                            <td class="editable" id="location<?php echo $employee['employeeID']; ?>" contenteditable="false"><?php echo $employee['location']; ?></td>
                            <td class="editable" id="zone<?php echo $employee['employeeID']; ?>" contenteditable="false"><?php echo $employee['zone']; ?></td>
                            <td>
                                <button type="button" class="btn" id="editbtn<?php echo $employee['employeeID']; ?>" style="display:  inline-block;" onclick="edit('<?php echo $employee['employeeID']; ?>')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 640 512">
                                        <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H322.8c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7l40.3-40.3c-32.1-31-75.7-50.1-123.9-50.1H178.3zm435.5-68.3c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM375.9 417c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L576.1 358.7l-71-71L375.9 417z" />
                                    </svg>
                                </button>
                                <button type="button" class="btn" id="savebtn<?php echo $employee['employeeID']; ?>" style="display: none;" onclick="save('<?php echo $employee['employeeID']; ?>')" name="UpdateEmployee">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 448 512">
                                        <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V173.3c0-17-6.7-33.3-18.7-45.3L352 50.7C340 38.7 323.7 32 306.7 32H64zm0 96c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V128zM224 416c-35.3 0-64-28.7-64-64s28.7-64 64-64s64 28.7 64 64s-28.7 64-64 64z" />
                                    </svg>
                                </button>
                                <button type="button" class="btn delbtn d-inline-block" id="<?php echo $employee['employeeID']; ?>" data-name="<?php echo $employee['nickname']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 640 512">
                                        <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L353.3 251.6C407.9 237 448 187.2 448 128C448 57.3 390.7 0 320 0C250.2 0 193.5 55.8 192 125.2L38.8 5.1zM264.3 304.3C170.5 309.4 96 387.2 96 482.3c0 16.4 13.3 29.7 29.7 29.7H514.3c3.9 0 7.6-.7 11-2.1l-261-205.6z" />
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
    <?php include "../services/footer.php"; ?>
    <script>
        let editing = false;
        //gibt id zu modal, wird zum löschen gebraucht
        $('#datatable').on('draw.dt', function() {
            $(document).ready(function() {
                $("employeeimg_").on("click", function() {
                    var id = $(this).attr("id");
                    var EmployeeName = $(this).attr("data-name");
                    //zeigt modal
                    $("#DeleteEmployeeModal").modal("show");
                    //macht id in hidden input 
                    document.getElementById("DelEmployeeID").setAttribute('value', id);
                    //zeigt name in span element mit id employeename
                    document.getElementById("EmployeeName").innerHTML = EmployeeName;
                });

            });
        });


        function EditImage(row) {
            if (editing == true) {
                $("#UpdateImage").modal("show");
                var employeeID = $(row).data("id")
                $("#updatepfp").attr("src", $(row).attr("src"));

                $("#submitupdateimage").click(function() {
                    console.log("test")
                    const formData = new FormData();
                    const fileData = $('#employeeimageupdate').prop('files')[0]
                    formData.append('image', fileData)
                    formData.append('employeeID', employeeID)
                    formData.append('path', $(row).attr("src"))
                    $.ajax({
                        type: "POST",
                        url: "../services/controller/employee_image_update.php",
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(data) {
                            if (data.status != "success") {
                                alert("Error!");
                            }
                        }
                    });
                });
            }
        }

        function edit(row) {
            $("#row" + row).children().attr("contenteditable", "true");
            $("#editbtn" + row).toggle();
            $("#savebtn" + row).toggle();
            editing = !editing;
        }


        function save(row) {
            $("#row" + row).children().attr("contenteditable", "false");
            $("#editbtn" + row).toggle();
            $("#savebtn" + row).toggle();
            var children = $("#row" + row).not(".btn").children();
            var vars = children.map(function() {
                return $(this).html();
            }).get();
            $.post("../services/controller/employee_update.php", {
                updateID: row,
                updatedata: vars
            }, function(data) {
                if (data.status === "success") {
                    alert("Daten erfolgreich aktualisiert!");
                    location.reload();
                } else {
                    alert("Es gab einen fehler beim aktualisieren.");
                }
            });
        }


        $(window).on('load', function() {
            setTimeout(function() {
                $('.loader_wrapper').fadeOut();
            }, 500);
        });
    </script>

</body>

</html>