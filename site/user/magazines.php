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
            width: 140px;

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
    </style>

</head>

<body>


    <?php
    $showSearch = true;
    $showEmpDatalist = false;
    include "../services/nav_index.php";
    setnavvalues($showSearch, $showEmpDatalist);
    ?>

    <div class="loader_wrapper">
        <div class="spinner-border" role="status">
        </div>
    </div>

    <div class="container-fluid p-3 min-vh-100">
        <div class="table-wrapper align-middle">
            <table id="datatable" class="table">
                <thead>
                    <tr class="header">
                        <th scope="col" style="width: 50%; text-align: left !important;">Titel:</th>
                        <th scope="col" style="text-align: right !important;">Autor:</th>
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
                                <td class="table-align-left ellipsis"><?php echo $row['magazine_title']; ?></td>
                                <td class="table-align-right ellipsis"><?php echo $row['magazine_autor']; ?></td>
                                <td>
                                    <button type="button" class="btn border-0" onclick="MagazineModal(this)" data-magazine='[&#34;<?php echo $row['magazine_title']; ?>&#34;, &#34;<?php echo $row['magazine_autor']; ?>&#34;, &#34;<?php echo $row['magazine_edition_j']; ?>&#34;, &#34;<?php echo $row['magazine_edition']; ?>&#34;, &#34;<?php echo $row['magazineID']; ?>&#34;, &#34;<?php echo $row['magazine_image']; ?>&#34;, &#34;<?php echo $row['magazine_language']; ?>&#34;]' data-bs-toggle="tooltip" data-bs-title="Zyrkulation">
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
    <!-- Vertically centered modal -->
    <div class="modal fade" id="MagazineModal" tabindex="-1" aria-labelledby="MagazineModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body ">
                    <div class="d-flex align-items-center ps-3" style="height:40vh;">
                        <img style="height:80%;" class="img-fluid rounded" id="magCover" src="" alt="">
                        <ul class="list-group list-group-flush ms-3 w-100">
                            <li class="list-group-item">
                                Titel: <span id="MagazineTitle"></span>
                            </li>
                            <li class="list-group-item">Autor: <span id="MagazineAutor"></span></li>
                            <li class="list-group-item">Sprache: <span id="MagazineLanguage"></span></li>
                            <li class="list-group-item">Ausgabe: <span id="MagazineCurrent"></span> / <span id="MagazineTotal"></span></li>
                        </ul>
                        <div class="flex-grow-1 h-100 d-flex justify-content-end">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>

                    <h4 class="ms-3">Zirkulation:</h4>
                    <div class="d-flex flex-wrap align-items-center" id="subs_wrapper">
                        <form method="post" id="AddSubForm">
                            <div class="chip m-2" id="modify_chip">
                                <select class="chip_input" aria-label="Default select example" id="chip_input_field">
                                    <option selected></option>
                                    <?php
                                    include "../../site/services/db_connect.php";

                                    $statement = $conn->prepare("SELECT nickname,employeeID from AeBo_employees ORDER BY nickname ASC");
                                    $statement->execute();
                                    $result = $statement->get_result();
                                    if ($result->num_rows != 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $nickname = $row['nickname'];
                                            $employeeID = $row['employeeID'];
                                            echo
                                            '<option class="" id="option_' . $nickname . '" value="' . $employeeID . '">' . $nickname . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <span class="RemoveSub" onclick="AddSubBtn()">&#43;</span>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" onclick="ResetInputs()">Zurück</button>
                    <button class="btn btn-primary border-0" type="button" data-bs-target="#MagazineModalConfirm" data-bs-toggle="modal">Speichern</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="MagazineModalConfirm" aria-hidden="true" aria-labelledby="MagazineModalConfirmLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="MagazineModalConfirmLabel">Wollen sie folgende Änderungen Speichern?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group" id="RemovedSubsList">
                        <li class="list-group-item">Zirkulation:</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="ResetInputs()">Abbrechen</button>
                    <button type="button" class="btn btn-success" data-magazneID data-bs-toggle="modal" onclick="ConfirmSubs()">Änderungen Bestätigen </button>
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
    <!--JavaScript-->
    <script src="../../assets/vendor/js/script.js"></script>

</body>