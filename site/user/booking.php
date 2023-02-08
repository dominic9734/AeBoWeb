<?php

include "../../site/services/db_connect.php";

if (mysqli_connect_errno()) {
    echo "Verbindung zu SQL Fehlgeschlagen: " . mysqli_connect_error();
}
$ausgeliehen = 1;
$error = 0;
$date = date("Y-m-d");
$buchID = $_GET['bookID'];


if (isset($_POST['submit'])) {

    if (empty($_POST["mitarbeiterkrz"])) {
        $vorname_err = "Bitte geben sie ein Kürzel an.";
    } else {
        $nickname = ($_POST["mitarbeiterkrz"]);
    }

    if (empty(($_POST["employeeID"]))) {
        $nachname_err = "";
    } else {
        $employeeID = ($_POST["employeeID"]);
    }

    if (empty(($_POST["date"]))) {
        $date_err = "Bitte geben sie ein Datum ein.";
    } else {
        $date = ($_POST["date"]);
    }

    $statement = $conn->prepare('SELECT nickname FROM AeBo_employees WHERE BINARY nickname = ?');
    $statement->bind_param("s", $nickname);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows == 0) {
        $error = 1;
    } else {

        $statement = $conn->prepare("INSERT INTO lib_borrowing (datum,nickname ,buchID)values (?,?,?)");
        $statement->bind_param("ssi", $date, $nickname, $buchID);
        $statement->execute();

        $buchausleihstatus = 1;
        $statement = $conn->prepare('UPDATE lib_books SET  ausgeliehen = ? where buchID = ?');
        $statement->bind_param('ii', $buchausleihstatus, $buchID);
        $statement->execute();

        header("location: books.php");
        exit();
    }
}

$statement = $conn->prepare("SELECT buch_titel FROM lib_books where buchID = ?");
$statement->bind_param("i", $buchID);
$statement->execute();
$result = $statement->get_result();
if ($result->num_rows != 0) {
    while ($row = $result->fetch_assoc()) {
        $buch_titel = $row['buch_titel'];
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

    <!-- Bootstrap -->
    <link href=../../assets/vendor/bootstrap/bootstrap.min.css rel="stylesheet">

    <link rel="stylesheet" href="../../assets/style/loginstyle.css">
</head>

<body>



    <!-- Modal -->
    <div class="modal hide fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kürzel falsch!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bitte wählen Sie ein Kürzel aus der Liste.
                </div>
            </div>
        </div>
    </div>



    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="wrap">
                        <div>
                            <img src="../../assets/svg/logo_full.svg" class="rounded mx-auto d-block img-fluid mb-5 mt-5">
                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100 pb-2">
                                    <h3 class="mb-4">Reservieren</h3>
                                    <h6><?php echo $buch_titel; ?></h6>
                                </div>
                            </div>
                            <form method="post" class="signin-form">
                                <div class="form-group mt-3">
                                    <input id="exampleDataList" type="text" name="mitarbeiterkrz" class="form-control" list="datalistOptions" autocomplete="off" required>
                                    <label class="form-control-placeholder" for="exampleDataList">Kürzel</label>
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
                                    <input hidden type="text" value="<?php $return_date; ?>" name="date">
                                    <div class="form-group mt-3">
                                        <button type="submit" name="submit" class="form-control btn btn-primary rounded submit px-3">Buchen
                                        </button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Bootstrap -->
    <script src="../../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="../../assets/vendor/jquery/jquery-3.5.1.js"></script>

    <?php
    if ($error == 1) {
        echo "<script type='text/javascript'>
    $(document).ready(function(){
    $('#Modal').modal('show');
    });
    </script>";
    }
    ?>


</body>

</html>