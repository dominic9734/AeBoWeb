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
            fill: #D00244;
            cursor: pointer;
        }

        .plan_fill_none {
            fill: lightgray;
            stroke: white;
            stroke-width: 4px;
            height: 50vh;
        }

        .plan_fill_active {
            fill: #D00244 !important;

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
            height: 60px;
            font-size: 22px;
            font-weight: 500;
            line-height: 60px;
            border-radius: 30px;
            background-color: #f1f1f1;
            width: 180px;

            position: relative;
        }

        .chip img {
            float: left;
            margin: 0 10px 0 -25px;
            height: 60px;
            width: 60px;
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
    include "../services/nav_index.php";
    setnavvalues($showSearch, $showEmpDatalist);
    ?>

    <div class="loader_wrapper">
        <div class="spinner-border" role="status">
        </div>
    </div>

    <div id="content" class="container-fluid text-center">
        <h1 class="text-center pt-3">Arbeitsplatzverteilung</h1>
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
                        <path class="plan_fill_none" d="m1971.6,1178.66h-138.84v67.44h138.84v-67.44Zm-123,.23v67.44m15.35-67.67v67.44m15.31-67.1v67.44m15.35-67.67v67.44m14.98-67.1v67.44m15.35-67.67v67.44m15.31-67.1v67.44m15.35-67.67v67.44m15.98-147.8h-138.84v67.44h138.84v-67.44Zm-123,.23v67.44m15.35-67.67v67.44m15.31-67.1v67.44m15.35-67.67v67.44m14.98-67.1v67.44m15.35-67.67v67.44m15.31-67.1v67.44m15.35-67.67v67.44m-93.33,263.7h-72.83v114.5h72.83v-114.5Zm-36.42,0v114.5m-17.88-128.42l-11.15,8.61h22.3l-11.15-8.61Zm34.74,8.61l11.15-8.61h-22.3s11.15,8.61,11.15,8.61Zm169.33,5.31h-72.83v114.5h72.83v-114.5Zm-36.42,0v114.5m-17.88-128.42l-11.15,8.61h22.3l-11.15-8.61Zm34.74,8.61l11.15-8.61h-22.3s11.15,8.61,11.15,8.61Zm161.94,193.96h-399.33v-534.47h399.33v534.47Z" />
                        <polygon class="plan_fill_none" points="2704.68 1407.12 2704.68 1937.13 1755.12 1937.13 1755.12 1618.77 2154.45 1618.77 2154.45 1084.3 2328.51 1084.3 2328.51 1407.12 2704.68 1407.12" />
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
                    <ul class="list-group list-group-flush m-3">
                        <li class="list-group-item">
                            <div class="d-flex align-items-center pb-3" style="height: 100px;">
                                <span id="wrapper_pfp"></span>
                                <h3 class="m-0 ps-3"><span id="full_name"></span></h3>
                                <div class="flex-grow-1 h-100 d-flex justify-content-end">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
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
    <!-- JavaScript-->
    <script src="../../assets/vendor/js/script.js"></script>

</body>

</html>