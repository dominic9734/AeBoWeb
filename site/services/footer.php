<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
?>
    <footer class="bd-footer py-4 py-md-5 mt-5 bg-light">
        <div class="container py-4 py-md-5 px-4 px-md-3 min-vh-75">
            <div class="row">
                <div class="col-6 col-lg-2 offset-lg-1 mb-3">
                    <h5>Administration</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="../admin/library.php" class="link-secondary text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="../admin/books.php" class="link-secondary text-decoration-none">Info</a></li>
                        <li class="mb-2"><a href="../admin/bookshistory.php.php" class="link-secondary text-decoration-none">Ausgeliehene Bücher</a></li>
                        <li class="mb-2"><a href="../admin/archive.php" class="link-secondary text-decoration-none">Admin</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2 offset-lg-1 mb-3">
                    <h5>Buchverwaltung</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="../admin/add_book.php" class="link-secondary text-decoration-none">Buch Hinzufügen</a></li>
                        <li class="mb-2"><a href="../admin/order_book_library.php" class="link-secondary text-decoration-none">Buch Bestellen</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2 offset-lg-1 mb-3">
                    <h5>Daten</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="../admin/export.php" class="link-secondary text-decoration-none">Daten-Export</a></li>
                        <li class="mb-2"><a href="../admin/db_export_books.php" class="link-secondary text-decoration-none">Daten-Upload</a></li>
                        <li class="mb-2"><a href="../admin/mitarbeiterdb_export_books.php" class="link-secondary text-decoration-none">Mitarbeiter-Upload</a></li>
                        <li class="mb-2"><a href="../admin/register.php" class="link-secondary text-decoration-none">register</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
<?php
} else {
?>
    <footer class="bd-footer py-4 py-md-5 mt-5 bg-light">
        <div class="container py-4 py-md-5 px-4 px-md-3 min-vh-75">
            <div class="row">
                <div class="col-lg-3 mb-3 ">
                    <a class="d-inline-flex align-items-center mb-2 link-dark text-decoration-none" href="/" aria-label="Bootstrap">
                        <span class="fs-5">Aegerter & Bosshardt AG</span>
                    </a>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2 ">
                            Die Zukunft entsteht in der Gegenwart
                        </li>
                        <li class="mb-2 ">
                            Wir gehen auf die Bedürfnisse der Kunden ein und bieten ihnen genau das, was sie brauchen
                            und was ihnen nützt. Wir sind eine dynamische Unternehmung mit offener Kommunikation nach
                            innen und aussen
                        </li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2 offset-lg-1 mb-3">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="http://www.aebo.ch/" class="link-secondary text-decoration-none">AEBO</a></li>
                        <li class="mb-2"><a href="../user/books.php" class="link-secondary text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="../user/info.php" class="link-secondary text-decoration-none">Info</a></li>
                        <li class="mb-2"><a href="../user/unavailable.php" class="link-secondary text-decoration-none">Ausgeliehene Bücher</a></li>
                        <li class="mb-2"><a href="../admin/library.php" class="link-secondary text-decoration-none">Admin</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
<?php
}

?>