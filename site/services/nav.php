<?php
function setnavvalues($showSearch)
{
    $showSearch;
}
?>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom d-flex" style="height: 60px;">
    <a class="navbar-brand p-0 mx-3" data-bs-toggle="offcanvas" href="#NavOffcanvas" role="button" aria-controls="NavOffcanvas">
        <!-- hamburger -->
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
        </svg>
        <!-- end hamburger -->
    </a>
    <div class="input-group my-2 flex-grow-1">
        <?php
        if ($showSearch) { ?>
            <input id="txtSearch" class="nav_search w-100" placeholder="Suchen..." />
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
                    <a class="navbar-brand d-flex align-items-center mx-3" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                        </svg>
                    </a>
                </div>
                <ul class="list-unstyled px-3 pt-2">
                    <li class="mb-1">
                        <div class="bd-links-heading d-flex align-items-center">
                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                            </svg>
                            Home
                        </div>
                        <div class="" id="administration-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-light pb-1 small">
                                <li><a class="link-dark rounded text-muted" href="../admin/index.php">Home</a></li>
                                <li><a class="link-dark rounded text-muted" href="../admin/employees.php">Mitarbeiter</a></li>
                            </ul>
                        </div>
                    </li>


                    <li class="mb-1">
                        <div class="bd-links-heading d-flex align-items-center">
                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z" />
                            </svg>
                            Bibliothek
                        </div>
                        <div class="" id="Buchverwaltung-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-light pb-1 small">
                                <li><a class="link-dark rounded text-muted text-muted" href="../admin/library.php">Bibliothek</a></li>
                                <li><a class="link-dark rounded text-muted" href="../admin/books.php">Übersicht</a></li>
                                <li><a class="link-dark rounded text-muted" href="../admin/bookrequests.php">Buch Bestellen</a></li>
                                <li><a class="link-dark rounded text-muted" href="../admin/bookshistory.php">Historie</a></li>
                                <li><a class="link-dark rounded text-muted" href="../admin/archive.php">Archiv</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="mb-1">
                        <div class="bd-links-heading d-flex align-items-center">
                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M249.6 471.5c10.8 3.8 22.4-4.1 22.4-15.5V78.6c0-4.2-1.6-8.4-5-11C247.4 52 202.4 32 144 32C93.5 32 46.3 45.3 18.1 56.1C6.8 60.5 0 71.7 0 83.8V454.1c0 11.9 12.8 20.2 24.1 16.5C55.6 460.1 105.5 448 144 448c33.9 0 79 14 105.6 23.5zm76.8 0C353 462 398.1 448 432 448c38.5 0 88.4 12.1 119.9 22.6c11.3 3.8 24.1-4.6 24.1-16.5V83.8c0-12.1-6.8-23.3-18.1-27.6C529.7 45.3 482.5 32 432 32c-58.4 0-103.4 20-123 35.6c-3.3 2.6-5 6.8-5 11V456c0 11.4 11.7 19.3 22.4 15.5z" />
                            </svg>
                            Zeitschriften
                        </div>
                        <div class="" id="Daten-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-light pb-1 small">
                                <li><a class="link-dark rounded text-muted" href="../admin/magazines.php">Zeitschriften</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="border-top my-3"></li>
                    <li class="mb-1">
                        <div class="bd-links-heading d-flex align-items-center">
                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                            </svg>
                            Acoount
                        </div>
                        <div class="" id="account-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-light pb-1 small">
                                <li><a class="link-dark rounded text-muted" href="../user/index.php">Benutzerbereich</a></li>
                                <li><a class="link-dark rounded text-muted" href="../services/register.php">Neuer User</a></li>
                                <li> <a class="link-dark rounded text-muted" href="../services/logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>