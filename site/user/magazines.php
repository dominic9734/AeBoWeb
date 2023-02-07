<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AEBO-Library</title>
    <link rel="icon" type="image/x-icon" href="../../assets/svg/favicon.svg">

    <link href=../../assets/vendor/bootstrap/bootstrap.min.css rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../../assets/style/style.css">
    <style>
        .chip {
            display: inline-block;
            padding: 0 25px;
            height: 50px;
            font-size: 18px;
            line-height: 50px;
            border-radius: 25px;
            background-color: #f1f1f1;
            width: 125px;

            position: relative;
        }

        .chip img {
            float: left;
            margin: 0 10px 0 -25px;
            height: 50px;
            width: 50px;
            border-radius: 50%;
        }

        .RemoveSub {
            padding-left: 10px;
            color: #888;
            font-weight: bold;
            float: right;
            font-size: 20px;
            cursor: pointer;
            position: absolute;
            margin-right: 20px;
            right: 0px;
            margin-right: 10px;

        }

        .cursor-pointer {
            cursor: pointer;
        }

        .RemoveSub:hover {
            color: #000;
        }

        .chip_input {
            border: 0;
            background-color: transparent;
            height: 40px;
            width: 100%;
            padding-left: 10px;
        }

        label {
            position: relative;
        }

        label:before {
            content: "";
            position: absolute;
            left: -10px;
            top: 0;
            bottom: 0;
            width: 20px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' height='20px' width='20px' viewBox='0 0 640 512' fill-rule='evenodd'%3E%3Cpath d='M352 128c0 70.7-57.3 128-128 128s-128-57.3-128-128S153.3 0 224 0s128 57.3 128 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z'%3E%3C/path%3E%3C/svg%3E") center / contain no-repeat;
        }

        .sorting {
            display: none;
        }
    </style>

</head>

<body>


    <?php
    $showSearch = true;
    include "../services/nav_index.php"; ?>

    <div class="container-fluid">
        <div class="card mt-3">
            <div class="card-body">
                <div class="table-wrapper align-middle">
                    <table id="datatable" class="table">
                        <thead>
                            <tr class="header">
                                <th scope="col" style="width: 10%; text-align: left !important;"></th>
                                <th scope="col" style="width: 60%; text-align: left !important;"></th>
                                <th scope="col" style="width: 20%; text-align: right !important; "></th>
                                <th scope="col" style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../../site/services/db_connect.php";
                            $statement = $conn->prepare("SELECT * FROM lib_magazines");

                            $statement->execute();
                            $result = $statement->get_result();

                            if ($result->num_rows != 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td class="table-align-left ellipsis"></td>

                                        <td class="table-align-left ellipsis"><?php echo $row['magazine_title']; ?></td>
                                        <td class="table-align-right ellipsis"><?php echo $row['magazine_autor']; ?></td>
                                        <td>
                                            <button type="button" class="btn border-0" onclick="MagazineModal(this)" data-MagazineTitle="<?php echo $row['magazine_title']; ?>" data-id="<?php echo $row['magazineID']; ?>" data-subscribers="<?php echo $row['magazine_subscribers']; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path d="M0 224c0 17.7 14.3 32 32 32s32-14.3 32-32c0-53 43-96 96-96H320v32c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l64-64c12.5-12.5 12.5-32.8 0-45.3l-64-64c-9.2-9.2-22.9-11.9-34.9-6.9S320 19.1 320 32V64H160C71.6 64 0 135.6 0 224zm512 64c0-17.7-14.3-32-32-32s-32 14.3-32 32c0 53-43 96-96 96H192V352c0-12.9-7.8-24.6-19.8-29.6s-25.7-2.2-34.9 6.9l-64 64c-12.5 12.5-12.5 32.8 0 45.3l64 64c9.2 9.2 22.9 11.9 34.9 6.9s19.8-16.6 19.8-29.6V448H352c88.4 0 160-71.6 160-160z" />
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
            </div>
        </div>
    </div>
    <!-- Vertically centered modal -->
    <div class="modal fade" id="MagazineModal" tabindex="-1" aria-labelledby="MagazineModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <p> <span id="MagazineTitle"></span>Zirkulation</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-wrap align-items-center" id="subs_wrapper">
                        <form method="post" id="AddSubForm">
                            <div class="chip m-2" id="modify_chip">
                                <label>
                                    <input class="chip_input" id="chip_input_field" name="chip_input_field" list="EmployeeNames" autocomplete="off" value="">
                                </label>
                                <span class="RemoveSub" onclick="AddSubBtn()">&#43;</span>
                                <datalist id="EmployeeNames">
                                    <?php
                                    include "../../site/services/db_connect.php";

                                    $statement = $conn->prepare("SELECT nickname from AeBo_employees ORDER BY nickname ASC");
                                    $statement->execute();
                                    $result = $statement->get_result();
                                    if ($result->num_rows != 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $mitarbeiterkrz = $row['nickname'];
                                            echo
                                            '<option value="' . $mitarbeiterkrz . '">';
                                        }
                                    }
                                    ?>
                                </datalist>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" onclick="ResetInputs()">Abbrechen</button>
                    <button class="btn btn-primary border-0" type="button" data-bs-target="#MagazineModalConfirm" data-bs-toggle="modal">Steichern</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="MagazineModalConfirm" aria-hidden="true" aria-labelledby="MagazineModalConfirmLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="MagazineModalConfirmLabel">Wollen sie folgende Änderungen speichern?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group" id="RemovedSubsList">
                        <li class="list-group-item">Zirkulation:</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="ResetInputs()">Abbrechen</button>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" onclick="ConfirmSubs()">Änderungen Bestätigen </button>
                </div>
            </div>
        </div>
    </div>






    <?php include "../services/footer.php" ?>
    <!--  Bootstrap -->
    <script src="../../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="../../assets/vendor/jquery/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <!-- Datatables -->
    <script src="../../assets/vendor/datatables/datatables.min.js"></script>
    <!-- Tables Config -->
    <script src="../../assets/vendor/datatables/tables.js"></script>
    <!--Loading screen-->
    <script src="../../assets/vendor/js/loading.js"></script>

    <script>
        var RemovedEmployees = []; // array for all the from the delivery list removed employees
        var AddedEmployees = []; // array for all the from the delivery list added employees
        let IDs, names, paths;


        // Data has to be formated like this to be passed as subs [1,2,3] type = string
        function DataAjax(subscribers) {
            let request = JSON.parse(subscribers);
            $.ajax({
                type: "POST",
                url: "../services/controller/mag_images.php",
                data: {
                    request: request
                },
                async: false,
                success: function(data) {
                    var response = JSON.parse(data);
                    IDs = response.IDs;
                    names = response.names;
                    paths = response.paths;
                }
            });
        }

        function ResetInputs() {
            RemovedEmployees = []
            AddedEmployees = []
            $("#RemovedSubsList").empty();
        }

        function ConfirmSubs() {
            console.log(RemovedEmployees);
            console.log(AddedEmployees);
            $.ajax({
                type: "POST",
                url: "../services/controller/mag_addsubs.php",
                data: {
                    RemovedEmployees: RemovedEmployees,
                    AddedEmployees: AddedEmployees
                },
                async: false,
                success: function(data) {
    
                    console.log(data)
                }
            });
        }

        function MagazineModal(entry) {
            var MagazineTitle = entry.dataset.magazinetitle; // get magazine title from entry element's data attribute
            var id = entry.dataset.id; // get id from entry element's data attribute
            var subscribers = entry.dataset.subscribers; // get subscribers from entry element's data attribute
            $("#MagazineTitle").html(MagazineTitle); // set the magazine title in the modal
            if (subscribers.length > 0) {
                DataAjax(subscribers, IDs, paths, names)
                AddChips()
            }
            $("#MagazineModal").modal("show"); // show the modal
        }

        function AddChips() {
            for (var i = 0; i < IDs.length; i++) {

                var divContainer = $("#subs_wrapper"); // get the container element for the current employee
                divContainer.removeClass("d-none").addClass(" p-2"); // show the container and set its class to  p-2
                $("#employee-input-container, #filler_div").addClass("d-none"); // hide input container and filler div

                var divChip = $('<div>', { // create a new chip element
                    class: 'chip m-2',
                    id: "employeeID_" + IDs[i]
                });
                var img = $('<img>', { // create a new img element
                    id: 'img-' + (i),
                    src: paths[i],
                    alt: "MA"
                });
                var spanDisplayName = $('<span>', { // create a new span element for the employee's display name
                    id: 'displayname-' + (i + 1),
                    html: names[i]
                });
                var spanRemove = $('<span>', { // create a new span element for the remove button
                    class: 'RemoveSub',
                    html: '&times;',
                    "data-value": IDs[i],
                    "data-name": names[i],
                    "data-position": [i],
                    onclick: "RemoveEmployee(this)"
                });
                var spanDivider = $('<div>', { // create a new span element for the divider
                    class: 'mx-1 text-cente',
                    id: "devider_" + IDs[i],
                    html: ' &#62;'
                });

                var modify_chip = $("#modify_chip").detach()

                divChip.append(img, spanDisplayName, spanRemove); // append the img, display name and remove button to the chip element
                divContainer.append(divChip, spanDivider, ); // append the divider and chip element to the container
                divContainer.append(modify_chip);

                ModifyChip();
            }
        }

        //function to remove subscription chips from the dom and add their value to a hidden input
        function RemoveEmployee(element) {
            RemovedEmployees.push(element.dataset.value) // push the employeeid value to the RemovedEmployees array
            $("#employeeID_" + (element.dataset.value)).addClass("d-none")
            $("#devider_" + (element.dataset.value)).addClass("d-none")

            var RemovedSubsListItem = $('<li>', { // create a new list element
                class: 'list-group-item',
                html: "&#45; " + element.dataset.name
            });
            $("#RemovedSubsList").append(RemovedSubsListItem);
            ModifyChip();
        }

        function ModifyChip() {
            if ($(".chip").not(".d-none").length > 12) {
                $("#modify_chip").hide();
            } else {
                $("#modify_chip").show();
            }
        }



        function AddSubBtn() {
            var chip_input_field_value = $("#chip_input_field").val();
            $.ajax({
                type: "POST",
                url: "../services/controller/input_validation.php",
                data: {
                    validation_input: chip_input_field_value,
                },
                success: function(data) {
                    if (data.response == "valid") {
                        $("#chip_input_field").val('');
                        var AddedSubsListItem = $('<li>', { // create a new list element
                            class: 'list-group-item',
                            html: "&#43; " + chip_input_field_value
                        });
                        $("#RemovedSubsList").append(AddedSubsListItem);
                        var subscribers = JSON.parse(data.ID);
                        AddedEmployees.push(subscribers.toString());
                        DataAjax("[" + subscribers.toString() + "]");
                        AddChips()
                    } else {
                        alert("Bitte wählen sie ein vorgegebenen Kürzel.")
                    }
                }
            });
            $("#chip_input_field").val('');
        }
    </script>
</body>