<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AEBO-Library</title>
    <link rel="icon" type="image/x-icon" href="../../../assets/svg/favicon.svg">
    <link href=../../../assets/vendor/bootstrap/bootstrap.min.css rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style/style.css">
    <!--  Bootstrap -->
    <script src="../../../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include "../../../site/services/db_connect.php";

    $members = [];

    $statement = $conn->prepare("SELECT nickname,magazine_title FROM `junction_magazines` LEFT JOIN aebo_employees ON aebo_employees.employeeID = junction_magazines.employeeID RIGHT JOIN lib_magazines ON lib_magazines.magazineID = junction_magazines.magazineID WHERE junction_magazines.magazineID = ?");
    $statement->bind_param("i", $_GET['ID']);
    $statement->execute();
    $result = $statement->get_result();
    if ($result->num_rows != 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($members, $row['nickname']);
        }
        $count = count($members);
    }
    ?>

    <div class="container">
        <span id="magazine_title">titel</span>
        <p>Ausgabe/Jahr</p>
        <p>Ausgabe/Nr.</p>
        <p>Zirkulationsdatum</p>
        <h2>Bitte innert Wochenfrist weiterleiten</h2>

        <div class="container">
            <div class="row row-cols-auto">
                <div class="col border border-2 border-bottom-0" style="width:150px;">
                    <h5>zirkulation</h5>
                </div>
                <?php
                foreach ($members as $m) {

                    echo '
                            <div class="col border border-2 border-bottom-0 border-start-0" style="width:50px;">
                            ' . $m . '
                            </div>
                            ';
                }
                ?>

            </div>
            <div class="row row-cols-auto">
                <div class="col border border-2" style="width:150px;">
                    <h5>Datum weitergabe</h5>
                </div>
                <?php
                $i = 0;
                do {
                    echo '
                    <div class="col border border-2 border-start-0" style="width:50px;">
                    </div>
                            ';
                    $i++;
                } while ($i < $count);
                ?>
            </div>
            <div class="row row-cols-auto">
                <div class="col border border-2 border-top-0" style="width:150px;">
                    <h5>Visum</h5>
                </div>
                <?php
                $i = 0;
                do {
                    echo '
                    <div class="col border border-2 border-top-0 border-start-0" style="width:50px;">
                    </div>
                            ';
                    $i++;
                } while ($i < $count);
                ?>
            </div>
        </div>
    </div>
</body>

</html>
<?php
/*
require __DIR__ . "/../../../assets/vendor/autoload.php";
// reference the Dompdf namespace
use Dompdf\Dompdf;
// instantiate and use the dompdf class
$dompdf = new Dompdf();
$html = '<h1>Hello, world!</h1>';
$dompdf->loadHtml($html);
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("zirkulation.pdf", ["Attachment" => 0]);

*/
?>