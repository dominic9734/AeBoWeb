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


if (session_id() == '') {
    session_start();
}

// in dem formular wird registrit
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty(trim($_POST["username"]))) {
        $username_err = "Bitte geben sie einen Benutzername ein.";
    } else {

        $sql = "SELECT userID FROM aebo_administrators WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);
            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "Dieser Benutzername existiert bereits.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Es gab einen Fehler, probieren sie es später nochmal.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // schaut ob es ein password hat
    if (empty(trim($_POST["password"]))) {
        $password_err = "Bitte geben sie ein Passwort ein.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Das Passwort muss mindestens 6 Zeichen lang sein.";
    } else {
        $password = trim($_POST["password"]);
    }

    // schaut ob passwörter stimmen
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Bitte verifizieren sie ihr Passwort";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Die Passwörter stimmen nicht überein.";
        }
    }


    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // macht user in user db
        $sql = "INSERT INTO aebo_administrators (username, password) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);


            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if (mysqli_stmt_execute($stmt)) {

                header("location: index.php");
            } else {
                echo "Etwas ist schief gelaufen. Bitte versuchen sie es später nochmal.";
            }


            mysqli_stmt_close($stmt);
        }
    }


    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="icon" type="image/x-icon" href="../../assets/svg/favicon.svg">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
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
                            <form form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="signin-form">
                                <div class="form-group mt-3">
                                    <input type="text" class="form-control" name="username" required>
                                    <label class="form-control-placeholder" for="username">Benutzername</label>
                                </div>
                                <div class="form-group">
                                    <input id="password-field" type="password" name="password" class="form-control" required>
                                    <label class="form-control-placeholder" for="password">Passwort</label>
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <div class="form-group">
                                    <input id="confirm_password-field" type="password" name="confirm_password" class="form-control" required>
                                    <label class="form-control-placeholder" for="confirm_password">Passwort bestätigen</label>
                                    <span toggle="#confirmpassword-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Registrieren</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

</body>

</html>