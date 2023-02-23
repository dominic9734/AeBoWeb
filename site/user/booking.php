<?php

include "../../site/services/db_connect.php";

if (mysqli_connect_errno()) {
    echo "Verbindung zu SQL Fehlgeschlagen: " . mysqli_connect_error();
}
$bookID = $_GET['bookID'];

if (isset($_POST['submit'])) {
    echo $bookID;
    $statement = $conn->prepare("INSERT INTO junction_books (bookID,employeeID)values (?,?)");
    $statement->bind_param("ii", $bookID, $_POST["emplyeeID"]);
    $statement->execute();

    $statement = $conn->prepare('UPDATE lib_books SET  borrowed = "1" where bookID = ?');
    $statement->bind_param('i', $bookID);
    $statement->execute();

    header("location: books.php");
    exit();
}


$statement = $conn->prepare("SELECT book_title FROM lib_books where bookID = ?");
$statement->bind_param("i", $bookID);
$statement->execute();
$result = $statement->get_result();
if ($result->num_rows != 0) {
    while ($row = $result->fetch_assoc()) {
        $book_title = $row['book_title'];
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
    <!--  Bootstrap -->
    <script src="../../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="../../assets/vendor/jquery/jquery-3.5.1.js"></script>
    <!-- JavaScript-->
    <script src="../../assets/vendor/js/script.js"></script>
</head>

<body>
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
                                    <h6><?php echo $book_title; ?></h6>
                                </div>
                            </div>
                            <form method="post" class="signin-form">
                                <div class="form-group mt-3">
                                    <!-- IPA-->
                                    <select name="emplyeeID" id="emplyeeselect" class="form-control" aria-label="Default select example" required>
                                        <option selected>Wählen...</option>

                                        <label class="form-control-placeholder" for="emplyeeselect">Kürzel</label>
                                        <?php
                                        $statement = $conn->prepare("SELECT nickname,employeeID from AeBo_employees");
                                        $statement->execute();
                                        $result = $statement->get_result();
                                        if ($result->num_rows != 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo
                                                ' 
                                                <option value="' . $row['employeeID'] . '">' . $row['nickname'] . ' ';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <!--end IPA-->
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