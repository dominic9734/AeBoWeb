<?php
session_start();
include "../../site/services/db_connect.php";

$username = $_SESSION["username"];
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../services/login.php");
    exit;
}
if (session_id() == '') {
    session_start();
}
$statement = $conn->prepare("SELECT * FROM lib_books");
$statement->execute();
$result = $statement->get_result();

if (isset($_GET['status'])) {
    if ( htmlspecialchars($_GET['status']) == "succ") {
        echo " 
    <script>
      alert('Buch erfolgreich hinzugefügt!');
    </script>
    ";
    } elseif ( htmlspecialchars($_GET['status']) == "err") {
        echo " 
    <script>
      alert('Es gab einen Fehler beim hinzufügen.');
    </script>
    ";
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

</head>

<body>
    <?php
    $showSearch = True; 
    include "../services/nav.php"; ?>
    <div class="container-fluid">
        <div class="card mt-3">
            <div class="card-body w-100">
                <table id="datatable" class="table">
                    <thead>
                        <tr class="header">
                            <th scope="col" style="width: 5%">#</th>
                            <th scope="col" style="width: 65%">Titel</th>
                            <th scope="col" style="width: 10%">Autor</th>
                            <th scope="col" style="width: 2.5%">Ausgabe</th>
                            <th scope="col" style="width: 2.5%">Verfügbar</th>
                            <th scope="col" style="width: 2.5%">Bearbeiten</th>
                            <th scope="col" style="width: 2.5%">Löschen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows != 0) {
                            while ($row = $result->fetch_assoc()) {
                                $id = $row['buchID'];
                                if ($row['geloescht'] == 0) {

                        ?>
                                    <tr>
                                        <th scope="row"><?php echo $row['buch_nummer']; ?></th>
                                        <td class="table-align-left table-size-65"><?php echo $row['buch_titel']; ?></td>
                                        <td class="table-align-right"><?php echo $row['buch_autor']; ?></td>
                                        <td class="table-align-center"><?php echo $row['buch_ausgabe']; ?></td>
                                        <td>
                                            <a href="" style="pointer-events: none; " type="button" class="btn border-0">
                                                <?php
                                                if ($row['ausgeliehen'] == 1) {
                                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/></svg>';
                                                } else {
                                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>';
                                                }
                                                ?>
                                            </a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn border-0 editbtn" data-id="<?php echo $row['buchID']; ?>" data-bemerkung="<?php echo $row['buch_bemerkung']; ?>" data-kurzbeschrieb="<?php echo $row['buch_kurzbeschrieb']; ?>" data-nummer="<?php echo $row['buch_nummer']; ?>" data-titel="<?php echo $row['buch_titel']; ?>" data-autor="<?php echo $row['buch_autor']; ?>" data-ausagbe="<?php echo $row['buch_ausgabe']; ?>" data-physisch="<?php echo $row['physisch']; ?>" data-virtuell="<?php echo $row['virtuell']; ?>" onclick="EditModal(this)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 512 512">
                                                    <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.8 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                                </svg>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn border-0" data-id="<?php echo $row['buchID']; ?>" data-nummer="<?php echo $row['buch_nummer']; ?>" onclick="DeleteModal(this)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 448 512">
                                                    <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                        <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="AddBookToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="max-width: 70px; max-height: 70px;">
                <div class="toast-body">
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#AddBookModal" style="display: inline;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 448 512">
                                <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- löschen Modal -->
    <div class="modal fade" id="DeleteBookModal" tabindex="-1" aria-labelledby="DeleteBookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DeleteModalLabel">Löschen Bestätigen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Wollen sie das Buch Nr. <span id="BookNumber"></span> wirklich löschen?
                </div>
                <div class="modal-footer">
                    <form method="post" action="functions.php">
                        <input type="text" hidden id="delete_restoreID" name="delete_restoreID" value="">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button class="btn btn-outline-danger border-0" type="submit" data-toggle="modal" name="delete_restore">Löschen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Erstellen Modal -->
    <div class="modal fade" id="AddBookModal" tabindex="-1" aria-labelledby="AddBookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddBookModalLabel">
                        Buch hinzufügen
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form method="post" id="addForm" action="functions.php" enctype="multipart/form-data">
                            <div class="input-group mb-3 mt-1">
                                <span class="input-group-text" id="basic-addon1" style="width: 20%">Titel</span>
                                <input name="buch_titel" type="text" class="form-control" aria-describedby="basic-addon1" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" style="width: 20%">Autor / Ausgabe</span>
                                <input name="buch_autor" type="text" class="form-control" required>
                                <input name="buch_ausgabe" type="text" class="form-control" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" style="width: 20%">Kurzbeschrieb / Nummer</span>
                                <input name="kurzbeschrieb" type="text" class="form-control">
                                <input name="buch_nummer" type="text" class="form-control" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" style="width: 20%">Bemerkung</span>
                                <textarea name="buch_bemerkung" class="form-control" aria-label="With textarea"></textarea>
                            </div>


                            <div class="mb-3">
                                <label for="formFile" class="form-label">Buchcover</label>
                                <input class="form-control" type="file" id="cover" name="jpg_file" accept=".jpg">
                                <input hidden type="text" name="DirectoryBook" value="/../../assets/images/book/">
                            </div>

                            <div class="row align-items-center mb-2">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="BookCheckbox" name="physisch">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Als Buch vorhanden
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="PDFCheckbox" name="virtuell">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Als PDF vorhanden
                                        </label>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">PDF Wählen </label>
                                        <input class="form-control" name="pdf_file" type="file" accept=".pdf" id="PDF">
                                        <input hidden type="text" name="DirectoryPDF" value="/../../assets/PDF/">
                                    </div>

                                </div>
                            </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger border-0" id="decline" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-outline-success border-0" id="accept" name="AddBook">Hinzufügen</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bearbeiten Modal -->
    <div class="modal fade" id="EditBookModal" tabindex="-1" aria-labelledby="EditBookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditBookModalLabel">
                        Buch bearbeiten
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form method="post" id="editBook" action="functions.php" enctype="multipart/form-data">
                            <div class="input-group mb-3 mt-1">
                                <input hidden type="text" value="" id="buchID" name="buchID">
                                <span class="input-group-text" id="basic-addon1" style="width: 20%">Titel</span>
                                <input name="buch_titel" id="buch_titel" type="text" class="form-control" aria-describedby="basic-addon1" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" style="width: 20%">Autor / Ausgabe</span>
                                <input name="buch_autor" id="buch_autor" type="text" class="form-control" value="" required>
                                <input name="buch_ausgabe" id="buch_ausgabe" type="text" class="form-control" value="" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" style="width: 20%">Kurzbeschrieb / Nummer</span>
                                <input name="buch_kurzbeschrieb" id="buch_kurzbeschrieb" type="text" class="form-control" value="">
                                <input name="buch_nummer" id="buch_nummer" type="text" class="form-control" value="" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" style="width: 20%">Bemerkung</span>
                                <textarea name="buch_bemerkung" id="buch_bemerkung" class="form-control" aria-label="With textarea" value=""></textarea>
                            </div>

                            <div class="row align-items-center mb-2">
                                <div class="col d-inline-flex">
                                    <div class="mb-3 pe-5">
                                        <label for="formFile" class="form-label">Buchcover</label>
                                        <input class="form-control" type="file" id="cover" name="jpg_file" accept=".jpg">
                                        <input hidden type="text" name="DirectoryBook" value="/../../assets/images/book/">
                                    </div>
                                    <div id="CoverImg" class="mb-3">
                                    </div>
                                </div>

                                <div class="col d-inline-flex">
                                    <div class="mb-3 pe-5">
                                        <label for="formFile" class="form-label">PDF Wählen </label>
                                        <input class="form-control" name="pdf_file" type="file" accept=".pdf" id="PDF">
                                        <input hidden type="text" name="DirectoryPDF" value="/../../assets/PDF/">
                                    </div>

                                    <div class="mb-3">
                                        <a id="PDFLink" href="" class="link-dark text-decoration-none" target="_blank" rel="noopener noreferrer">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" viewBox="0 0 384 512">
                                                <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM64 224H88c30.9 0 56 25.1 56 56s-25.1 56-56 56H80v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V320 240c0-8.8 7.2-16 16-16zm24 80c13.3 0 24-10.7 24-24s-10.7-24-24-24H80v48h8zm72-64c0-8.8 7.2-16 16-16h24c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H176c-8.8 0-16-7.2-16-16V240zm32 112h8c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16h-8v96zm96-128h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H304v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H304v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V304 240c0-8.8 7.2-16 16-16z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center mb-2">
                                <div class="col d-inline-flex">
                                    <div class="mb-3 pe-5">
                                        <label for="formFile" class="form-label">Buch Inhaltsverzeichnis</label>
                                        <input class="form-control" type="file" id="cover" name="jpg_file" accept=".jpg">
                                        <input hidden type="text" name="DirectoryBook" value="/../../assets/images/book/">
                                    </div>
                                    <div id="InhaltImg" class="mb-3">
                                    </div>
                                </div>

                                <div class="col d-inline-flex">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="BookCheckbox" name="physisch">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Als Buch vorhanden
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="PDFCheckbox" name="virtuell">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Als PDF vorhanden
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger border-0" id="decline" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-outline-success border-0" id="accept" name="EditBook">Speichern</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "../services/footer.php"; ?>
    <!--  Bootstrap -->
    <script src="../../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="../../assets/vendor/jquery/jquery-3.5.1.js"></script>
    <!-- Datatables -->
    <script src="../../assets/vendor/datatables/datatables.min.js"></script>
    <!-- Tables Config -->
    <script src="../../assets/vendor/datatables/tables.js"></script>
    <!--Loading screen-->
    <script src="../../assets/vendor/js/loading.js"></script>

    <script type="text/javascript">
        const toastLiveExample = document.getElementById('AddBookToast')
        const toast = new bootstrap.Toast(toastLiveExample)
        toast.show()
    </script>
    <script type="text/javascript">
        //https://vyspiansky.github.io/2019/07/13/javascript-at-least-one-checkbox-must-be-selected/

        const form = document.querySelector('#addForm');
        const checkboxes = form.querySelectorAll('input[type=checkbox]');
        const checkboxLength = checkboxes.length;
        const firstCheckbox = checkboxLength > 0 ? checkboxes[0] : null;

        function init() {
            if (firstCheckbox) {
                for (let i = 0; i < checkboxLength; i++) {
                    checkboxes[i].addEventListener('change', checkValidity);
                }

                checkValidity();
            }
        }

        function isChecked() {
            for (let i = 0; i < checkboxLength; i++) {
                if (checkboxes[i].checked) return true;
            }

            return false;
        }

        function checkValidity() {
            const errorMessage = !isChecked() ? 'Mindestens ein Kästchen muss markiert sein.' : '';
            firstCheckbox.setCustomValidity(errorMessage);
        }

        init();
    </script>
    <script>
        function DeleteModal(entry) {
            var id = entry.getAttribute("data-id");
            var BookNumber = entry.getAttribute("data-nummer");
            $("#DeleteBookModal").modal("show");
            //macht id in hidden input in delete modal
            document.getElementById("delete_restoreID").setAttribute('value', id);
            //zeigt name in span element mit id employeename
            document.getElementById("BookNumber").innerHTML = BookNumber;
        }

        function EditModal(entry) {
            var Bookid = entry.getAttribute("data-id");
            var Bookbemerkung = entry.getAttribute("data-bemerkung");
            var Bookkurzbeschrieb = entry.getAttribute("data-kurzbeschrieb");
            var Booknummer = entry.getAttribute("data-nummer");
            var Booktitel = entry.getAttribute("data-titel");
            var Bookautor = entry.getAttribute("data-autor");
            var Bookausgabe = entry.getAttribute("data-ausagbe");
            var Bookphysisch = entry.getAttribute("data-physisch");
            var Bookvirtuell = entry.getAttribute("data-virtuell");

            document.getElementById("buchID").setAttribute('value', Bookid);
            document.getElementById("buch_bemerkung").innerHTML = Bookbemerkung;
            document.getElementById("buch_kurzbeschrieb").setAttribute('value', Bookkurzbeschrieb);
            document.getElementById("buch_nummer").setAttribute('value', Booknummer);
            document.getElementById("buch_titel").setAttribute('value', Booktitel);
            document.getElementById("buch_autor").setAttribute('value', Bookautor);
            document.getElementById("buch_ausgabe").setAttribute('value', Bookausgabe);
            document.getElementById("buch_titel").setAttribute('value', Booktitel);
            document.getElementById("buch_titel").setAttribute('value', Booktitel);

            $("#EditBookModal").modal("show");
            //macht id in input im Modal
        }
    </script>
</body>

</html>