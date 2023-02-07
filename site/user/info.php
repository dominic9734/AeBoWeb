<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AEBO-Library</title>
    <link rel="icon" type="image/x-icon" href="../../assets/svg/favicon.svg">


    <link href=../../assets/vendor/bootstrap/bootstrap.min.css rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style/style.css">
    
    <style>
        p{
            margin-top: 30px ;
            margin-bottom: 30px ;
        }
    </style>

</head>
<body>
<?php include "../services/nav_index.php"; ?>

<div class="container-xxl px-4 px-xxl-2">
    <div class="mb-4 text-center text-lg-start">
        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title my-3 text-center">Gebrauchsanweisung</h4>
            </div>

            <div class="card-body p-5">
                <div class="justify-content-md-center mx-auto" style="width: 60%;">
                    <h2 class="card-subtitle mb-2 fw-bold">Einführung</h2>
                    <p></p>
                    <p class="card-text fw-semibold">In der AEBO-Library finden sie alle Bücher/Literaturen, welche sich in der
                        Betriebsinternen Bibliothek befinden.
                        Bücher können direkt über diese Seite zum Ausleihen reserviert werden.
                        Der Reservationsablauf läuft wie folgt ab.</p>
                    <h4 class="card-subtitle mb-2 fw-bold">1. Buch wählen</h4>
                    <p class="card-text fw-semibold"> Auf der Seite <a href="books.php" class="link-dark" >Home</a> finden sie eine Liste mit den
                        verfügbaren Büchern. Mit einem Klicken auf das <img src="../../assets/images/icons/bag.svg" alt=""> Symbol
                        werden sie zu der Resorvationsformular geleitet. </p>
                    <h4 class="card-subtitle mb-2 fw-bold">2. Buch reservieren</h4>
                    <img src="../../assets/images/img/buchen.png" class="d-block img-fluid mb-2 rounded border"
                         alt="Buchen-Seite" loading="lazy" width="1905" height="934">
                    <p class="card-text fw-semibold">Hier müssen sie ihr Kürzel aus der Liste wählen. Wählen sie nur ein Kürzel aus der Liste aus. Gibt es ihr Kürzel nicht, wenden sie sich bitte an den Bibliothekar.</p>
                    <h5 class="card-subtitle mb-2 fw-bold">3. Buch zurückgeben</h5>
                    <p class="card-text fw-semibold">Um ein Buch zurück zu geben, wenden Sie sich bitten an den zustädnigen Bibliothekar. Der Bibliothekar wird ihr Buch entgegen nehmen und das Buch zur erneuten ausleihe freigeben. </p>
                    <p class="card-text"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../services/footer.php"; ?>

<script src="../../assets/filter.js"></script>
<!--  Bootstrap -->
<script src="../../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
<!-- jquery -->
<script src="../../assets/vendor/jquery/jquery-3.5.1.js"></script>
<!-- Datatables -->
<script src="../../assets/vendor/datatables/datatables.min.js"></script>
<!--Loading screen-->
<script src="../../assets/vendor/js/loading.js"></script>

</body>
</html>
