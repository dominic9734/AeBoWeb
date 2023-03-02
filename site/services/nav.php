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
                        <div class="bd-links-heading ps-3">
                            Home
                        </div>
                        <div class="" id="administration-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-light pb-1 small">
                                <li><a class="link-dark rounded text-muted" href="../admin/index">Home</a></li>
                                <li><a class="link-dark rounded text-muted" href="../admin/employees">Mitarbeiter</a></li>
                            </ul>
                        </div>
                    </li>


                    <li class="mb-1">
                        <div class="bd-links-heading ps-3">
                            Bibliothek
                        </div>
                        <div class="" id="Buchverwaltung-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-light pb-1 small">
                                <li><a class="link-dark rounded text-muted text-muted" href="../admin/library">Bibliothek</a></li>
                                <li><a class="link-dark rounded text-muted" href="../admin/books">Übersicht</a></li>
                                <li><a class="link-dark rounded text-muted" href="../admin/bookrequests">Buch Bestellen</a></li>
                                <li><a class="link-dark rounded text-muted" href="../admin/bookshistory">Historie</a></li>
                                <li><a class="link-dark rounded text-muted" href="../admin/archive">Archiv</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="mb-1">
                        <div class="bd-links-heading ps-3">
                            Zeitschriften
                        </div>
                        <div class="" id="Daten-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-light pb-1 small">
                                <li><a class="link-dark rounded text-muted" href="../admin/magazines">Zeitschriften</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="border-top my-3"></li>
                    <li class="mb-1">
                        <div class="bd-links-heading ps-3">
                            Acoount
                        </div>
                        <div class="" id="account-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-light pb-1 small">
                                <li><a class="link-dark rounded text-muted" href="../user/index">Benutzerbereich</a></li>
                                <li><a class="link-dark rounded text-muted" href="../services/register">Neuer User</a></li>
                                <li> <a class="link-dark rounded text-muted" href="../services/logout">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>