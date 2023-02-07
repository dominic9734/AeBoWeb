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
        .plan_fill_none:hover {
            fill: #ce0145;
            cursor: pointer;
        }

        .plan_fill_none {
            fill: lightgray;
            stroke: white;
            stroke-width: 4px;
            height: 50vh;
        }

        .plan_fill_active {
            fill: #ce0145 !important;

            box-shadow: 10px #646464;
        }

        .back_to_top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 32px;
            height: 32px;
            z-index: 9999;
            cursor: pointer;
            text-decoration: none;
            transition: opacity 0.2s ease-out;
            display: none;
        }

        .back_to_top:hover {
            opacity: 0.7;
        }

        .chip {
            display: inline-block;
            padding: 0 25px;
            height: 40px;
            font-size: 12px;
            line-height: 40px;
            border-radius: 20px;
            background-color: #f1f1f1;
            width: 120px;

            position: relative;
        }

        .chip img {
            float: left;
            margin: 0 10px 0 -25px;
            height: 40px;
            width: 40px;
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

        .floor_container {
            height: 100vh;
            border-style: solid;
            border: 2px;
            border-color: #000;
        }

        .profile_img {
            width: 75px;
        }
    </style>


</head>

<body class="index_background">
    <?php
    $showSearch = true;
    $showEmpDatalist = true;
    include "../services/nav_index.php"; ?>

    <div class="loader_wrapper">
        <div class="spinner-border" role="status">
        </div>
    </div>

    <div id="content" class="container text-center">
        <h1 class="text-center pt-3">Platzverteilung</h1>
        <div class="row">
            <div class="col">
                <h1 id="wrapper_room_label_floor_3" class="my-4 d-none remove_header">Räume</h1>
                <div class="floor_container remove_content " id="wrapper_rooms_floor_3">
                </div>
            </div>
            <div class="col-6">
                <div class="floor_container" id="floor_3">
                    <h1 class="text-center my-4">3.OG</h1>
                    <svg id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4167.36 2526.12">
                        <rect onclick="btnSVG(this)" id="3_D" class="plan_fill_none" x="1771.69" y="1927.08" width="949.56" height="479.19" />
                        <polygon onclick="btnSVG(this)" id="3_B" class="plan_fill_none" points="1771.69 240.33 1771.69 1074.25 2345.09 1074.25 2345.09 1397.07 2721.25 1397.07 2721.25 1074.25 2721.25 240.33 1771.69 240.33" />
                        <polygon onclick="btnSVG(this)" id="3_A" class="plan_fill_none" points="2344.3 1397.07 2344.3 1074.25 1771.69 1074.25 1771.69 1397.07 1771.69 1927.08 2721.25 1927.08 2721.25 1397.07 2344.3 1397.07" />
                        <rect onclick="btnSVG(this)" id="3_C" class="plan_fill_none" x="2721.25" y="1240.4" width="539.31" height="792.04" />
                        <rect onclick="btnSVG(this)" id="3_E" class="plan_fill_none" x="1200.36" y="1250.04" width="571.33" height="782.4" />
                        <polygon onclick="btnSVG(this)" id="3_F" class="plan_fill_none" points="910.32 1926.96 910.32 1616.37 822.57 1616.37 822.57 1091.28 350.04 1091.28 350.04 1616.37 350.04 2191.2 910.32 2191.2 1200.36 2191.2 1200.36 1926.96 910.32 1926.96" />
                        <polygon onclick="btnSVG(this)" class="plan_fill_none" points="822.57 1091.28 822.57 1616.37 910.32 1616.37 910.32 1926.96 1200.36 1926.96 1200.36 1616.37 1200.36 1091.28 822.57 1091.28" />
                    </svg>
                </div>
            </div>
            <div class="col">
                <h1 id="wrapper_label_floor_3" class="my-4 d-none remove_header">Mitarbeiter</h1>
                <div class="floor_container remove_content  pt-5" id="wrapper_floor_3"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h1 id="wrapper_room_label_floor_4" class="my-4 d-none remove_header">Räume</h1>
                <div class="floor_container remove_content " id="wrapper_rooms_floor_4">
                </div>
            </div>
            <div class=" col-6">
                <div class="floor_container" id="floor_4">
                    <h1 class="text-center my-4">4.OG</h1>
                    <svg id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4167.36 2526.12">
                        <rect onclick="btnSVG(this)" onclick="btnSVG(this)" id="4_D" class="plan_fill_none" x="1771.69" y="1927.08" width="949.56" height="479.19" />
                        <polygon onclick="btnSVG(this)" id="4_B" class="plan_fill_none" points="1771.69 240.33 1771.69 1074.25 2345.09 1074.25 2345.09 1397.07 2721.25 1397.07 2721.25 1074.25 2721.25 240.33 1771.69 240.33" />
                        <polygon onclick="btnSVG(this)" id="4_A" class="plan_fill_none" points="2344.3 1397.07 2344.3 1074.25 1771.69 1074.25 1771.69 1397.07 1771.69 1927.08 2721.25 1927.08 2721.25 1397.07 2344.3 1397.07" />
                        <rect onclick="btnSVG(this)" id="4_C" class="plan_fill_none" x="2721.25" y="1240.4" width="539.31" height="792.04" />
                        <rect onclick="btnSVG(this)" id="4_E" class="plan_fill_none" x="1200.36" y="1250.04" width="571.33" height="782.4" />
                        <polygon onclick="btnSVG(this)" id="4_F" class="plan_fill_none" points="910.32 1926.96 910.32 1616.37 822.57 1616.37 822.57 1091.28 350.04 1091.28 350.04 1616.37 350.04 2191.2 910.32 2191.2 1200.36 2191.2 1200.36 1926.96 910.32 1926.96" />
                        <polygon onclick="btnSVG(this)" class="plan_fill_none" points="822.57 1091.28 822.57 1616.37 910.32 1616.37 910.32 1926.96 1200.36 1926.96 1200.36 1616.37 1200.36 1091.28 822.57 1091.28" />
                    </svg>
                </div>
            </div>
            <div class="col">
                <h1 id="wrapper_label_floor_4" class="my-4 d-none remove_header">Mitarbeiter</h1>
                <div class="floor_container remove_content  pt-5" id="wrapper_floor_4"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h1 id="wrapper_room_label_floor_5" class="my-4 d-none remove_header">Räume</h1>
                <div class="floor_container remove_content " id="wrapper_rooms_floor_5">
                </div>
            </div>
            <div class=" col-6">
                <div class="floor_container" id="floor_5">
                    <h1 class="text-center my-4">5.OG</h1>
                    <svg id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4167.36 2526.12">
                        <rect onclick="btnSVG(this)" id="5_D" class="plan_fill_none" x="1771.69" y="1927.08" width="949.56" height="479.19" />
                        <polygon onclick="btnSVG(this)" id="5_B" class="plan_fill_none" points="1771.69 240.33 1771.69 1074.25 2345.09 1074.25 2345.09 1397.07 2721.25 1397.07 2721.25 1074.25 2721.25 240.33 1771.69 240.33" />
                        <polygon onclick="btnSVG(this)" id="5_A" class="plan_fill_none" points="2344.3 1397.07 2344.3 1074.25 1771.69 1074.25 1771.69 1397.07 1771.69 1927.08 2721.25 1927.08 2721.25 1397.07 2344.3 1397.07" />
                        <rect onclick="btnSVG(this)" id="5_C" class="plan_fill_none" x="2721.25" y="1240.4" width="539.31" height="792.04" />
                        <rect onclick="btnSVG(this)" id="5_E" class="plan_fill_none" x="1200.36" y="1250.04" width="571.33" height="782.4" />
                        <polygon onclick="btnSVG(this)" id="5_F" class="plan_fill_none" points="910.32 1926.96 910.32 1616.37 822.57 1616.37 822.57 1091.28 350.04 1091.28 350.04 1616.37 350.04 2191.2 910.32 2191.2 1200.36 2191.2 1200.36 1926.96 910.32 1926.96" />
                        <polygon onclick="btnSVG(this)" class="plan_fill_none" points="822.57 1091.28 822.57 1616.37 910.32 1616.37 910.32 1926.96 1200.36 1926.96 1200.36 1616.37 1200.36 1091.28 822.57 1091.28" />
                    </svg>
                </div>
            </div>
            <div class="col">
                <h1 id="wrapper_label_floor_5" class="my-4 d-none remove_header">Mitarbeiter</h1>
                <div class="floor_container remove_content  pt-5" id="wrapper_floor_5"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h1 id="wrapper_room_label_floor_6" class="my-4 d-none remove_header">Räume</h1>
                <div class="floor_container remove_content " id="wrapper_rooms_floor_6">
                </div>
            </div>
            <div class=" col-6">
                <div class="floor_container" id="floor_6">
                    <h1 class="text-center my-4">6 - OG</h1>
                    <svg id="svg_center" class="pt-0" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4167 2525.76">
                        <rect onclick="btnSVG(this)" id="6_D" class="plan_fill_none" x="1755.12" y="1937.13" width="949.56" height="479.19" />
                        <polygon onclick="btnSVG(this)" id="6_B" class="plan_fill_none" points="1755.12 250.38 1755.12 1084.3 2328.51 1084.3 2328.51 1407.12 2704.68 1407.12 2704.68 1084.3 2704.68 250.38 1755.12 250.38" />
                        <polygon onclick="btnSVG(this)" class="plan_fill_none" points="2327.72 1407.12 2327.72 1084.3 1755.12 1084.3 1755.12 1407.12 1755.12 1937.13 2704.68 1937.13 2704.68 1407.12 2327.72 1407.12" />
                    </svg>
                </div>
            </div>
            <div class="col">
                <h1 id="wrapper_label_floor_6" class="my-4 d-none remove_header">Mitarbeiter</h1>
                <div class="floor_container remove_content " id="wrapper_floor_6">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="EmployeeInfo" tabindex="-1" aria-labelledby="EmployeeInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="d-flex flex-row-reverse" id="work_division_header">
                        <button type="button" class="btn-close m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <ul class="list-group list-group-flush m-3">
                        <li class="list-group-item">
                            <div class="d-flex align-items-center pb-3">
                                <span id="wrapper_pfp"></span>
                                <h3 class="m-0 ps-3"><span id="full_name"></span></h3>
                            </div>
                            <p class="mb-1"><small class="text-muted" id="special_authority"></small></p>
                            <p><small class="text-muted" id="department"></small></p>
                        </li>
                        <li class="list-group-item">
                            <p><span class="user-select-all" id="primary_mail"></span></p>
                            <p><span id="internal_phone"></span></p>
                            <p><span id="mobile_phone"></span></p>
                        </li>
                        <li class="list-group-item">
                            <a href="" class="pe-2" id="mailto_outlook">
                                <img src="../../assets/SVG/icons8-microsoft-outlook-2019.svg" alt=""></a>
                            <a target="_blank" href="" class="pe-2" id="link_teams">
                                <img src="../../assets/SVG/icons8-microsoft-teams.svg" alt="">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade min-vh-25" id="RoomInfo" tabindex="-1" aria-labelledby="RoomInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body ">
                    <h1 class="m-3 text-center"><span id="room_name"></span></h1>
                    <div id="wrapper_png"></div>
                    <div id="wrapper_room_content">
                    </div>
                </div>
            </div>
        </div>
    </div>





    <svg class="back_to_top" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
        <path d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z" />
    </svg>


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

    <script>
        var lastpressed, request, seat, scope_all, floor;

    
        $(window).on('load', function() {
            $('.loader_wrapper').hide();
        })


        function btnSVG(element) {
            let location_info = element.id.split("_");
            request = location_info;
            request_scope = "query";
            $(".remove_content").empty();
            $(".remove_header").addClass("d-none")
            DataAjaxChip(request, request_scope);
            $("#" + element.id).addClass("plan_fill_active")
            if (lastpressed && lastpressed != element.id) {
                $("#" + lastpressed).removeClass("plan_fill_active")
            }
            lastpressed = element.id;
        }

        function DataAjaxChip(request, request_scope) {
            $.ajax({
                type: "POST",
                url: "../services/controller/seating_data.php",
                data: {
                    location: request[0],
                    zone: request[1],
                    request_scope: request_scope

                    },
                    success: function(data) {
                        let employees = data.employees;
                        let rooms = data.rooms;
                        for (i = 0; i < employees.length; i++) {
                            employee = employees[i];
                        var divContainer = $("#wrapper_floor_" + employee.location); // get the container element for the current employee
                        var divChip = $('<div>', {
                            class: 'chip m-2 cursor-pointer',
                            id: "employeeID_" + employee.ID,
                            "data-employee": JSON.stringify(employee)
                        });
                        divChip.click(function() {
                            DisplayEmoloyeeInfo(this)
                        });
                        var img = $('<img>', { // create a new img element
                            id: 'img-' + (i),
                            src: "../../assets/images/employees_200px/" + employee.nickname + ".png",
                            alt: " "
                        });
                        var spanDisplayName = $('<span>', { // create a new span element for the employee's display name
                            html: employee.nickname
                        });
                        divChip.append(img, spanDisplayName); // append the img, display name and remove button to the chip element
                        divContainer.append(divChip); // append the divider and chip element to the container
                        $("#wrapper_label_floor_" + employee.location).removeClass("d-none");
                    }

                    for (i = 0; i < rooms.length; i++) {

                        room = rooms[i];
                        var divContainer = $("#wrapper_rooms_floor_" + room.location); // get the container element for the current employee
                        var divChip = $('<div>', {
                            class: 'chip m-2 cursor-pointer',
                            id: "roomID" + room.ID,
                            "data-room": JSON.stringify(room)
                        });
                        divChip.click(function() {
                            DisplayRoomInfo(this)
                        });
                        var spanDisplayName = $('<span>', { // create a new span element for the employee's display name
                            html: room.room_name
                        });
                        divChip.append(spanDisplayName); // append the img, display name and remove button to the chip element
                        divContainer.append(divChip); // append the divider and chip element to the container
                        $("#wrapper_room_label_floor_" + room.location).removeClass("d-none");
                    }
                }
            });
        }

        function DisplayEmoloyeeInfo(chip) {
            $("#employeePFP").remove()
            var employeeData = $(chip).data("employee");
            $("#EmployeeInfo").modal("show"); // show the modal

            var pfpimg = $('<img>', { // create a new img element
                id: 'employeePFP',
                class: 'rounded-circle shadow-sm profile_img',
                src: "../../assets/images/employees_200px/" + employeeData.nickname + ".png",
                alt: " "
            });


            $("#wrapper_pfp").append(pfpimg);

            $("#full_name").html(employeeData.first_name + " " + employeeData.last_name);
            $("#location").html(employeeData.location);
            $("#zone").html(employeeData.zone);
            $("#work_division").html(employeeData.work_division);
            $("#internal_phone").html("Intern: +41 61 365 2 " + employeeData.internal_phone);
            if (employeeData.mobile_phone) {
                $("#mobile_phone").html("Privat: " + employeeData.mobile_phone);
            }
            $("#primary_mail").html(employeeData.primary_mail);
            $("#special_authority").html(employeeData.special_authority);
            $("#department").html(employeeData.department);

            $("#mailto_outlook").attr("href", "mailto:" + employeeData.primary_mail);
            $("#link_teams").attr("href", "https://teams.microsoft.com/l/chat/0/0?users=" + employeeData.primary_mail);

        }

        function DisplayRoomInfo(chip) {
            var roomData = $(chip).data("room");
            $("#RoomInfo").modal("show"); // show the modal

            $("#wrapper_png").empty();
            $("#room_name").html(roomData.room_name);

            var room_name = roomData.room_name.replace(/\s/g, "_");


            var roomPNG = $('<img>', { // create a new img element
                id: 'roomPNG',
                class: 'img-fluid rounded mb-3 d-block',
                src: "../../assets/images/img/" + room_name + ".jpg",
                alt: ""
            });
            $("#wrapper_png").append(roomPNG);

            $.ajax({
                type: "POST",
                url: "../services/controller/seating_data.php",
                data: {

                    location: roomData.location,
                    zone: roomData.zone,
                    work_division: roomData.work_division,
                    request_scope: "departmentquery"

                },
                success: function(data) {
                    $("#wrapper_room_content").empty();
                    let members = data.members;
                    var membersHeader = $('<h4 class="text-center m-2">Verantwortliche</h4>', { // create a new img element
                    });
                    if (members.length < 0) {
                        $("#wrapper_room_content").append(membersHeader);
                    }
                    if (members) {
                        for (i = 0; i < members.length; i++) {
                            member = data.members[i];
                            var row = $('<div>', { // create a new img element
                                class: 'row my-2',
                            });
                            var row2 = $('<div> ', { // create a new img element
                                class: 'col-2 pe-0'
                            });
                            var row8 = $('<div> ', { // create a new img element
                                class: 'col-6 ps-0 d-flex align-items-center'
                            });
                            var span = $('<span>', { // create a new img element
                            });
                            span.html(member.first_name + " " + member.last_name)
                            var row4 = $('<div>', { // create a new img element
                                class: 'col-4 d-flex justify-content-end',
                            });
                            var pfpimg = $('<img>', { // create a new img element
                                id: 'employeePFP',
                                class: 'rounded-circle shadow-sm',
                                src: "../../assets/images/employees_200px/" + member.nickname + ".png",
                                style: "height:40px;",
                                alt: " "
                            });
                            var outlooklink = $('<a>', { // create a new img element
                                class: 'pe-2',
                                href: "mailto:" + member.primary_mail
                            });
                            var teamslink = $('<a>', { // create a new img element
                                class: 'pe-2',
                                href: "https://teams.microsoft.com/l/chat/0/0?users=" + member.primary_mail
                            });

                            var outlookincon = $('<img>', { // create a new img element
                                src: '../../assets/SVG/icons8-microsoft-outlook-2019.svg',
                                style: "height:25px;"
                            });
                            var teamsicon = $('<img>', { // create a new img element
                                src: '../../assets/SVG/icons8-microsoft-teams.svg',
                                style: "height:25px;"
                            });
                            row2.append(pfpimg);
                            row8.append(span);
                            row4.append(outlooklink, teamslink);
                            outlooklink.append(outlookincon);
                            teamslink.append(teamsicon);
                            row.append(row2, row8, row4);
                            $("#wrapper_room_content").append(row);
                        }
                    }
                }
            });

        }
        $(document).ready(function() {

            //Check to see if the window is top if not then display button
            $(window).scroll(function() {

                // Show button after 100px
                var showAfter = 100;
                if ($(this).scrollTop() > showAfter) {
                    $('.back_to_top').fadeIn();
                } else {
                    $('.back_to_top').fadeOut();
                }
            });

            //Click event to scroll to top
            $('.back_to_top').click(function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });

        });


        $("input").keypress(function(event) {
            if (event.which == 13) {
                $(".remove_content").empty();
                $(".remove_header").addClass("d-none")
                $.ajax({
                    type: "POST",
                    url: "../services/controller/seating_data.php",
                    data: {
                        request: $("#txtSearch").val(),
                        request_scope: "location_zone"

                    },
                    success: function(data) {
                        seat = data.location + "_" + data.zone
                        floor = data.location;
                        sectorsearch(seat, floor);
                    }
                });
                $("#txtSearch").val('')
            }
        });


        function sectorsearch(seat, floor) {
            $("#" + seat).addClass("plan_fill_active")
            if (lastpressed && lastpressed != seat) {
                $("#" + lastpressed).removeClass("plan_fill_active")
            }
            lastpressed = seat;
            request = seat.split("_");
            request_scope = "query";

            $([document.documentElement, document.body]).animate({
                scrollTop: $("#" + "floor_" + floor).offset().top
            }, 1500);

            DataAjaxChip(request, request_scope);
        }
        $(document).keydown(function(event) {
            if (event.key === "Escape" || event.key === "Esc") {
                $(".plan_fill_none").removeClass("plan_fill_active")
                $(".remove_content").empty();
                $(".remove_header").addClass("d-none")


            }
        });
    </script>
</body>

</html>