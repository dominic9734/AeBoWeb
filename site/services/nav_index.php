<?php

function setnavvalues($showEmpDatalist, $showSearch)
{
    $showEmpDatalist;
    $showSearch;
}
?>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom d-flex" style="height: 60px;">
    <a class="navbar-brand p-0 mx-3 " data-bs-toggle="offcanvas" href="#NavOffcanvas" role="button" aria-controls="NavOffcanvas">
        <!-- hamburger -->
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
        </svg>
        <!-- end hamburger -->
    </a>
    <div class="input-group my-2 flex-grow-1">
        <?php
        if ($showSearch == true) {
        ?>
            <input id="txtSearch" oninput="SearchEmployee()" class="nav_search w-100" placeholder="Suchen..." <?php if ($showEmpDatalist == true) {
                                                                                                                    echo 'list="EmployeeNames"';
                                                                                                                } ?> />
        <?php
        }
        ?>

        <?php
        if ($showEmpDatalist) { ?>
            <datalist id="EmployeeNames">
                <?php
                include "../../site/services/db_connect.php";
                $statement = $conn->prepare('SELECT * from aebo_employees WHERE location <> "Mö"');
                $statement->execute();
                $result = $statement->get_result();
                if ($result->num_rows != 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo
                        '<option value="' . $row['nickname'] . '" data-employee="[&#34;' . $row['nickname'] . '&#34;,&#34;' . $row['first_name'] . '&#34;,&#34;' . $row['last_name'] . '&#34;,&#34;' . $row['location'] . '&#34;,&#34;' . $row['zone'] . '&#34;,&#34;' . $row['work_division'] . '&#34;,&#34;' . $row['internal_phone'] . '&#34;,&#34;' . $row['mobile_phone'] . '&#34;]">' . $row['nickname'] . " - " . $row['last_name'] . " " . $row['first_name'] . '</option>';
                    }
                }
                $statement = $conn->prepare("SELECT * from AeBo_rooms");
                $statement->execute();
                $result = $statement->get_result();
                if ($result->num_rows != 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo
                        '<option value="' . $row['room_name'] . '" data-room="[&#34;' . $row['room_name'] . '&#34]">' . $row['room_name'] . " ";
                        if ($row['room_name'] != $row['room_displayname']) {
                            echo $row['room_displayname'];
                        }
                        ' </option>';
                    }
                }
                ?>
            </datalist>
        <?php
        }
        ?>

    </div>

    <img class="pe-3" src="../../assets/SVG/logo_text.svg" alt="AEBO" style="height: 32px;">
</nav>

<div class="offcanvas offcanvas-nav offcanvas-start" tabindex="-1" id="NavOffcanvas" aria-labelledby="NavOffcanvasLabel">
    <div class="offcanvas-body offcanvas-body-nav">
        <div class="dropdown">
            <div class="flex-shrink-0 bg-white" style="width: 280px;">
                <div class="sidebar-nav-header d-flex align-items-center" style="height: 60px;">
                    <a class="navbar-brand d-flex align-items-center mx-3" data-bs-toggle="offcanvas" href="#NavOffcanvas" role="button" aria-controls="NavOffcanvas">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                        </svg>
                    </a>
                </div>

                <ul class="list-unstyled px-3 pt-2">
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed ps-0" data-bs-toggle="collapse" data-bs-target="#administration-collapse" aria-expanded="true">
                            Generell
                        </button>
                        <div class="collapse show" id="administration-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a class="link-dark rounded" href="../user/index">Home</a></li>
                                <li><a class="link-dark rounded" href="../user/seatingplan">Arbeitsplatzverteilung</a></li>
                                <li><a class="link-dark rounded" href="../user/books">Bibliothek</a></li>
                                <li><a class="link-dark rounded" href="../user/magazines">Zeitschriften</a></li>
                                <li><a class="link-dark rounded" href="../user/getxml">Literaturverzeichnis</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="border-top my-3"></li>
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed ps-0" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="true">
                            Account
                        </button>
                        <div class="collapse show" id="account-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li> <a class="link-dark rounded" href="../admin/index">Admin</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>