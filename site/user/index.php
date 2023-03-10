<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AeBo-Web</title>
    <link rel="icon" type="image/x-icon" href="../../assets/svg/favicon.svg">

    <link href=../../assets/vendor/bootstrap/bootstrap.min.css rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style/style.css">
    <!--  Bootstrap -->
    <script src="../../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="../../assets/vendor/jquery/jquery-3.5.1.js"></script>
    <!-- JavaScript-->
    <script src="../../assets/vendor/js/script.js"></script>


</head>

<body class="index_background">
    <?php
    $showSearch = false;
    $showEmpDatalist = false;
    include "../services/nav_index.php";
    setnavvalues($showSearch, $showEmpDatalist); ?>
    <!--  Bootstrap 
    <div class="loader-wrapper">
        <div class="spinner-border" role="status">
        </div>
    </div>
    -->


    <div class="d-flex align-items-center vh-100 w-100">
        <div class="m-auto">
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-md-12 m-3">
                        <img src="../../assets/SVG/logo_full.svg" class="mb-5" alt="">
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex align-content-stretch flex-wrap">
                        <div class="card border-0 m-2" style="width: 18rem;">
                            <div class="card-body ">
                                <h5 class="card-title">Arbeitsplatzverteilung</h5>
                                <a href="seatingplan" class="card-link">Schnellzugriff</a>
                            </div>
                        </div>
                        <div class="card border-0 m-2" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Zeitschriften</h5>
                                <a href="magazines" class="card-link">Schnellzugriff</a>
                            </div>
                        </div>
                        <div class="card border-0 m-2" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Literaturverzeichnis</h5>
                                <a href="getxml" class="card-link">Schnellzugriff</a>
                            </div>
                        </div>
                        <div class="card border-0 m-2" style="width: 18rem;">
                            <div class="card-body ">
                                <h5 class="card-title">Bibliothek</h5>
                                <a href="books" class="card-link">Schnellzugriff</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <?php include_once "../services/footer.php"; ?>
</body>

</html>