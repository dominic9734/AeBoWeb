<?php

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../admin/admin.php");
    exit;
}

include "../../site/services/db_connect.php";

$username = $password = "";
$error = 0;


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty(trim($_POST["username"]))) {
        $error = 1;
    } else {
        $username = trim($_POST["username"]);
    }

    // schaut ob passwort leer ist
    if (empty(trim($_POST["password"]))) {
        $error = 1;
    } else {
        $password = trim($_POST["password"]);
    }

    // schaut ob passwort und username eingegeben ist
    if (empty($username_err) && empty($password_err)) {

        echo "test";

        $sql = "SELECT userID, username, password FROM AeBo_administrators WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($stmt, "s", $param_username);




            $param_username = $username;

            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {

                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password) == 1) {

                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["userID"] = $id;
                            $_SESSION["username"] = $username;

                            header("location: ../admin/index.php");
                        }
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="../../assets/svg/favicon.svg">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link href=../../assets/vendor/bootstrap/bootstrap.min.css rel="stylesheet">

    <link rel="stylesheet" href="../../assets/style/loginstyle.css">

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
                                <div class="w-100">
                                    <h3 class="mb-4">Login</h3>
                                </div>
                            </div>
                            <form form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="signin-form">
                                <div class="form-group my-4">
                                    <input type="text" class="form-control" name="username" required>
                                    <label class="form-control-placeholder" for="username">Benutzername</label>
                                </div>
                                <div class="form-group my-4">
                                    <input id="password-field" type="password" name="password" class="form-control" required>
                                    <label class="form-control-placeholder" for="password">Passwort</label>
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal hide fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Fehler!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bitte Wählen sie eines der vorgegebenen Kürzel.
                </div>
            </div>
        </div>
    </div>

    <!-- bootstrap -->
    <script src="../../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="../../assets/vendor/jquery/jquery-3.5.1.js"></script>

    <!--modal js-->
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