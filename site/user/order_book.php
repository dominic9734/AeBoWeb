<?php
include "../../site/services/db_connect.php";

if (mysqli_connect_errno()) {
    echo "Verbindung zu SQL Fehlgeschlagen: " . mysqli_connect_error();
}
//werte werden in tabelle eingesetzt
if (isset($_POST['submit'])) {
    $bestellung_autor = $_POST['bestellung_autor'];
    $bestellung_titel = $_POST['bestellung_titel'];
    $bestellung_ausgabe = $_POST['bestellung_ausgabe'];
    $bestellung_isbn = $_POST['bestellung_isbn'];
    $bestellung_bemerkung = $_POST['bestellung_bemerkung'];
    $bestellung_bestellername = $_POST['bestellung_bestellername'];
    $bestellung_datum = $_POST['bestellung_datum'];
    $bestellung_datum = date("Y-m-d");

    $statement = $conn->prepare('INSERT INTO lib_book_orders (bestellung_autor ,bestellung_titel,bestellung_ausgabe, bestellung_isbn, bestellung_bemerkung, bestellung_bestellername, bestellung_datum) VALUES(?,?,?,?,?,?,?)');
    $statement->bind_param('sssssss', $bestellung_autor, $bestellung_titel, $bestellung_ausgabe, $bestellung_isbn, $bestellung_bemerkung, $bestellung_bestellername, $bestellung_datum,);
    $statement->execute();
    echo "<script>window.close();</script>";
}
?>

<!doctype html>
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
    <div class="px-4  my-5 text-center">
        <h1 class="display-5 fw-bold">Buch Bestellen</h1>
        <div class="col-lg-6 mx-auto">
            <p class="mb-4">Geben sie die nötigen Buchspezifikationen an.</p>
        </div>
    </div>

    <div class='container-fluid'>
        <div class='card m-5'>
            <div class='card-body'>
                <form method='post'>
                    <div class='input-group mb-5 mt-1'>
                        <span class='input-group-text' id='basic-addon1' style='width: 20%'>Titel</span>
                        <input name='bestellung_titel' type='text' class='form-control' aria-label='Username' aria-describedby='basic-addon1' required>
                    </div>
                    <div class='input-group mb-5'>
                        <span class='input-group-text' style='width: 20%'>Autor / Ausgabe</span>
                        <input name='bestellung_autor' type='text' aria-label='First name' class='form-control'>
                        <input name='bestellung_ausgabe' type='text' aria-label='Last name' class='form-control'>
                    </div>

                    <div class='input-group mb-5 mt-1'>
                        <span class='input-group-text' id='basic-addon1' style='width: 20%'>ISBN</span>
                        <input name='bestellung_isbn' type='text' class='form-control' aria-label='Username' aria-describedby='basic-addon1'>
                    </div>

                    <div class='input-group mb-5'>
                        <span class='input-group-text' style='width: 20%'>Bemerkung</span>
                        <textarea name='bestellung_bemerkung' class='form-control' aria-label='With textarea'></textarea>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class='input-group mb-5'>
                                <input class="form-control" list="datalistOptions" name="bestellung_bestellername" id="exampleDataList" placeholder="Bestellername" autocomplete="off" required>
                                <datalist id="datalistOptions">
                                    <?php
                                    include "../../site/services/db_connect.php";

                                    $statement = $conn->prepare("SELECT nickname from AeBo_employees");
                                    $statement->execute();
                                    $result = $statement->get_result();
                                    if ($result->num_rows != 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $mitarbeiterkrz = $row['nickname'];
                                            echo
                                            '<option value="' . $mitarbeiterkrz . '">';
                                        }
                                    }
                                    ?>
                                </datalist>
                            </div>
                        </div>
                        <div class="col">
                            <div class="float-end">
                                <button href="#" onclick="close_window();return false;" class='btn btn-danger mb-3'>Zurück</button>
                                <button data-bs-toggle="modal" data-bs-target="#bestellModal" type="button" class='btn btn-success mb-3'>Bestellen</button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="bestellModal" tabindex="-1" aria-labelledby="bestellModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="returnModalLabel">Bestellen Bestätigen</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Wollen sie das Buch wirklich Bestellen?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Abbrechen</button>
                                    <button class="btn btn-outline-success" type="submit" id="close" data-toggle="modal" name="submit">Bestellen</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>



    <!--  Bootstrap -->
    <script src="../../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="../../assets/vendor/jquery/jquery-3.5.1.js"></script>
    <!--Loading screen-->
    <script src="../../assets/vendor/js/loading.js"></script>

    <script>
        function close_window() {
            close();
        }
    </script>

</body>

</html>