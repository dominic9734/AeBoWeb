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
$statement = $conn->prepare("SELECT * FROM lib_magazines");
$statement->execute();
$result = $statement->get_result();

if (isset($_GET['status'])) {
    if (htmlspecialchars($_GET['status']) == "succ") {
        echo " 
    <script>
      alert('Buch erfolgreich hinzugefügt!');
    </script>
    ";
    } elseif (htmlspecialchars($_GET['status']) == "err") {
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
    <div class="container-fluid p-3">
        <table id="datatable" class="table">
            <thead>
                <tr class="header">
                    <th scope="col" class="table-align-left" style="width: 40%;">Titel</th>
                    <th scope="col" class="table-align-right" style="width: 35%">Autor</th>
                    <th scope="col" class="table-align-center" style="width: 5%">Ausgabe/Jahr</th>
                    <th scope="col" class="table-align-center" style="width: 5%">Ausgabe Nr.</th>
                    <th scope="col" class="table-align-center" style="width: 5%">Zirkulationsdatum</th>
                    <th scope="col" class="table-align-center" style="width: 5%">Kosten</th>
                    <th scope="col" class="table-align-center" style="width: 5%"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows != 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row['magazineID'];
                        if ($row['deleted'] == 0) {

                ?>
                            <tr>
                                <th scope="row" class="table-align-left"><?php echo $row['magazine_title']; ?></th>
                                <td class="table-align-right"><?php echo $row['magazine_autor']; ?></td>
                                <td class="table-align-center"><?php echo $row['magazine_edition_j']; ?></td>
                                <td class="table-align-center"><?php echo $row['magazine_edition']; ?></td>
                                <td class="table-align-center"><?php echo $row['magazine_circulation_date']; ?></td>
                                <td class="table-align-center"><?php echo $row['magazine_price']; ?></td>
                                <td class="table-align-center">
                                    <div class="d-flex">
                                        <button type="button" class="btn border-0 d-inline" data-magazine='[&#34;<?php echo $row['magazine_title']; ?>&#34;, &#34;<?php echo $row['magazine_autor']; ?>&#34;, &#34;<?php echo $row['magazine_edition_j']; ?>&#34;, &#34;<?php echo $row['magazine_edition']; ?>&#34;, &#34;<?php echo $row['magazineID']; ?>&#34;]' onclick="EditModal(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 512 512">
                                                <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.8 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                            </svg>
                                        </button>
                                        <button type="button" class="btn border-0 d-inline" data-ID="<?php echo $row['magazineID']; ?>" data-number="<?php echo $row['magazine_title']; ?>" onclick="DeleteModal(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 448 512">
                                                <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                            </svg>
                                        </button>
                                        <button type="button" class="btn border-0 d-inline" data-id="<?php echo $row['buchID']; ?>" data-nummer="<?php echo $row['buch_nummer']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zm-16-88c-13.3 0-24-10.7-24-24s10.7-24 24-24s24 10.7 24 24s-10.7 24-24 24z" />
                                            </svg>
                                        </button>
                                    </div>
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

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="AddBookToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="max-width: 70px; max-height: 70px;">
            <div class="toast-body">
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#AddMagazineModal" style="display: inline;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 448 512">
                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                        </svg>
                    </button>
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
                    Wollen Sie die Zeitschrift <span id="BookNumber"></span> wirklich löschen?
                </div>
                <div class="modal-footer">
                    <form method="post" action="functions.php">
                        <input type="text" hidden id="magazineID" name="delete_restoreID" value="">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button class="btn btn-outline-danger border-0" type="submit" data-toggle="modal" name="delete_restore">Löschen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Erstellen Modal -->
    <div class="modal fade" id="AddMagazineModal" tabindex="-1" aria-labelledby="AddMagazineModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditMagazineModalLabel">
                        Zeitschrift hinzufügen
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form method="post" id="AddMagazine" action="functions.php" enctype="multipart/form-data">
                            <div class="input-group mb-3">
                                <span class="input-group-text" style="width: 20%">Titel</span>
                                <input name="magazine_title" id="" type="text" class="form-control" value="" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" style="width: 20%">Autor</span>
                                <input name="magazine_autor" id="" type="text" class="form-control" value="" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" style="width: 20%">Ausgabe/Jahr - Ausgabe Nr.</span>
                                <input name="magazine_edition_j" id="" type="text" class="form-control" value="" required>
                                <input name="magazine_edition" id="" type="text" class="form-control" value="" required>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col d-inline-flex">
                                    <div class="mb-3 pe-5">
                                        <label for="formFile" class="form-label">Zeitschrift-Cover</label>
                                        <input class="form-control" type="file" id="cover" name="jpg_file" accept=".jpg">
                                        <input hidden type="text" name="CoverDirectory" value="/../../assets/images/magazine/">
                                    </div>
                                    <div id="CoverImg" class="mb-3">
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger border-0" id="decline" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-outline-success border-0" id="accept" name="AddMagazine">Speichern</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bearbeiten Modal -->
    <div class="modal fade" id="EditMagazineModal" tabindex="-1" aria-labelledby="EditMagazineModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditMagazineModalLabel">
                        Zeitschrift bearbeiten
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form method="post" id="AddMagazine" action="functions.php" enctype="multipart/form-data">
                            <input name="magazineID" id="magazineIDedit" type="text" class="form-control" value="" hidden>
                            <div class="row text-center">
                                <div class="col-sm-6 col-md-8">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="width: 20%">Titel</span>
                                        <input name="magazine_title" id="magazine_title" type="text" class="form-control" value="" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="width: 20%">Autor</span>
                                        <input name="magazine_autor" id="magazine_autor" type="text" class="form-control" value="" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" style="width: 20%">Ausgabe</span>
                                        <input name="magazine_edition_j" id="magazine_edition_j" type="text" class="form-control" value="" required>
                                        <input name="magazine_edition" id="magazine_edition" type="text" class="form-control" value="" required>
                                    </div>
                                    <div class="">
                                        <label for="edit_cover" class="form-label mb-3">Zeitschriften Titelbild</label>
                                        <input class="form-control" placeholder="Cover .png" type="file" id="cover" name="edit_cover" accept=".png">
                                    </div>

                                </div>
                                <div class="col-6 col-md-4">
                                    <img id="editCover" class="img-thumbnail w-50" src="" alt="">
                                </div>

                            </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger border-0" id="decline" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-outline-success border-0" id="accept" name="EditMagazine">Speichern</button>
                </div>
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

        function DeleteModal(entry) {
            $("#magazineID").val($(entry).data("ID"));
            $("#BookNumber").html($(entry).data("number"));
            $("#DeleteBookModal").modal("show");
        }



        function EditModal(entry) {
            var magazineArray = $(entry).data("magazine");
            document.getElementById("magazine_title").setAttribute('value', magazineArray[0]);
            document.getElementById("magazine_autor").setAttribute('value', magazineArray[1]);
            document.getElementById("magazine_edition_j").setAttribute('value', magazineArray[2]);
            document.getElementById("magazine_edition").setAttribute('value', magazineArray[3]);
            document.getElementById("magazineIDedit").setAttribute('value', magazineArray[4]);
            document.getElementById("editCover").setAttribute('src', "../../assets/images/img/cover_mag_" + magazineArray[4] + ".png");

            $("#EditMagazineModal").modal("show");





        }
    </script>
</body>

</html>