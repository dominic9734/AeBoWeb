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
                        <button class="btn btn-toggle align-items-center rounded collapsed ps-0" data-bs-toggle="collapse" data-bs-target="#administration-collapse" aria-expanded="true">
                            Generell
                        </button>
                        <div class="collapse show" id="administration-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a class="link-dark rounded" href="../admin/index.php">Home</a></li>
                                <li><a class="link-dark rounded" href="../admin/employees.php">Mitarbeiter</a></li>
                            </ul>
                        </div>
                    </li>


                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed ps-0" data-bs-toggle="collapse" data-bs-target="#Buchverwaltung-collapse" aria-expanded="false">
                            Bibliothek
                        </button>
                        <div class="collapse" id="Buchverwaltung-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a class="link-dark rounded" href="../admin/library.php">Bibliothek</a></li>
                                <li><a class="link-dark rounded" href="../admin/books.php">Übersicht</a></li>
                                <li><a class="link-dark rounded" href="../admin/order_book_admin.php">Buch Bestellen</a></li>
                                <li><a class="link-dark rounded" href="../admin/bookshistory.php.php">Historie</a></li>
                                <li><a class="link-dark rounded" href="../admin/archive.php">Archiv</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed ps-0" data-bs-toggle="collapse" data-bs-target="#Daten-collapse" aria-expanded="false">
                            Zeitschriften
                        </button>
                        <div class="collapse" id="Daten-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a class="link-dark rounded" href="../admin/magazines.php">Zeitschriften</a></li>
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
                                <li><a class="link-dark rounded" href="../user/index.php">Benutzerbereich</a></li>
                                <li><a class="link-dark rounded" href="../services/register.php">Neuer User</a></li>
                                <li> <a class="link-dark rounded" href="../services/logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>