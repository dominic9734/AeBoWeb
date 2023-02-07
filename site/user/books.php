<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AEBO-Library</title>
    <link rel="icon" type="image/x-icon" href="../../assets/svg/favicon.svg">

    <link href=../../assets/vendor/bootstrap/bootstrap.min.css rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../../assets/style/style.css">


</head>

<body>
    <div class="content-wrapper">

        <?php
        $showSearch = true;
        include "../services/nav_index.php"; ?>

        <div class="container-fluid">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="table-wrapper align-middle">
                        <table id="datatable" class="table">
                            <thead>
                                <tr class="header">
                                    <th scope="col" style="width: 5%">#
                                    </th>
                                    <th scope="col" style="width: 55%; text-align: left !important;">Titel</th>
                                    <th scope="col" style="width: 20%; text-align: right !important; ">Autor</th>
                                    <th scope="col" style="width: 5%">Ausgabe</th>
                                    <th scope="col" style="width: 10%">Art</th>
                                    <th scope="col" style="width: 5%">Verfügbar</th>
                                    <th scope="col" style="width: 5%">Info</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "../../site/services/db_connect.php";
                                $statement = $conn->prepare("SELECT * FROM lib_books");
                                $statement->execute();
                                $result = $statement->get_result();

                                if ($result->num_rows != 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $buch_bemerkung = $row['buch_bemerkung'];
                                        $buch_kurzbeschrieb = $row['buch_kurzbeschrieb'];


                                        $folder = '../../assets/images/book/';
                                        $word = trim($row['buch_nummer']);
                                        $count = 0;

                                        // Use the glob function to get an array of all files in the folder
                                        $files = glob("$folder/*");

                                        // Iterate through the array of files
                                        foreach ($files as $file) {
                                            // Only count files, not directories
                                            if (is_file($file)) {
                                                $fileName = basename($file);
                                                // Check if the string is in the file name
                                                if (strpos($fileName, $word) !== false) {
                                                    $count++;
                                                }
                                            }
                                        }

                                        if ($count != 0) {
                                            $count--;
                                        }

                                        if ($row['geloescht'] == 0) {
                                ?>
                                            <tr>
                                                <th scope="row">
                                                    <?php echo $row['buch_nummer']; ?>
                                                </th>
                                                <td class="table-align-left table-size-65 ellipsis"><?php echo $row['buch_titel']; ?></td>
                                                <td class="table-align-right ellipsis"><?php echo $row['buch_autor']; ?></td>
                                                <td class="table-align-center"><?php echo $row['buch_ausgabe']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($row['physisch'] == 1 && $row['virtuell'] == 0) {
                                                    ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 448 512">
                                                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z" />
                                                        </svg>
                                                    <?php
                                                    } elseif ($row['virtuell'] == 1 && $row['physisch'] == 0) {
                                                    ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 384 512">
                                                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path d="M320 464C328.8 464 336 456.8 336 448V416H384V448C384 483.3 355.3 512 320 512H64C28.65 512 0 483.3 0 448V416H48V448C48 456.8 55.16 464 64 464H320zM256 160C238.3 160 224 145.7 224 128V48H64C55.16 48 48 55.16 48 64V192H0V64C0 28.65 28.65 0 64 0H229.5C246.5 0 262.7 6.743 274.7 18.75L365.3 109.3C377.3 121.3 384 137.5 384 154.5V192H336V160H256zM88 224C118.9 224 144 249.1 144 280C144 310.9 118.9 336 88 336H80V368C80 376.8 72.84 384 64 384C55.16 384 48 376.8 48 368V240C48 231.2 55.16 224 64 224H88zM112 280C112 266.7 101.3 256 88 256H80V304H88C101.3 304 112 293.3 112 280zM160 240C160 231.2 167.2 224 176 224H200C226.5 224 248 245.5 248 272V336C248 362.5 226.5 384 200 384H176C167.2 384 160 376.8 160 368V240zM192 352H200C208.8 352 216 344.8 216 336V272C216 263.2 208.8 256 200 256H192V352zM336 224C344.8 224 352 231.2 352 240C352 248.8 344.8 256 336 256H304V288H336C344.8 288 352 295.2 352 304C352 312.8 344.8 320 336 320H304V368C304 376.8 296.8 384 288 384C279.2 384 272 376.8 272 368V240C272 231.2 279.2 224 288 224H336z" />
                                                        </svg>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 448 512">
                                                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z" />
                                                        </svg>
                                                        /
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 384 512">
                                                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path d="M320 464C328.8 464 336 456.8 336 448V416H384V448C384 483.3 355.3 512 320 512H64C28.65 512 0 483.3 0 448V416H48V448C48 456.8 55.16 464 64 464H320zM256 160C238.3 160 224 145.7 224 128V48H64C55.16 48 48 55.16 48 64V192H0V64C0 28.65 28.65 0 64 0H229.5C246.5 0 262.7 6.743 274.7 18.75L365.3 109.3C377.3 121.3 384 137.5 384 154.5V192H336V160H256zM88 224C118.9 224 144 249.1 144 280C144 310.9 118.9 336 88 336H80V368C80 376.8 72.84 384 64 384C55.16 384 48 376.8 48 368V240C48 231.2 55.16 224 64 224H88zM112 280C112 266.7 101.3 256 88 256H80V304H88C101.3 304 112 293.3 112 280zM160 240C160 231.2 167.2 224 176 224H200C226.5 224 248 245.5 248 272V336C248 362.5 226.5 384 200 384H176C167.2 384 160 376.8 160 368V240zM192 352H200C208.8 352 216 344.8 216 336V272C216 263.2 208.8 256 200 256H192V352zM336 224C344.8 224 352 231.2 352 240C352 248.8 344.8 256 336 256H304V288H336C344.8 288 352 295.2 352 304C352 312.8 344.8 320 336 320H304V368C304 376.8 296.8 384 288 384C279.2 384 272 376.8 272 368V240C272 231.2 279.2 224 288 224H336z" />
                                                        </svg>

                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row['ausgeliehen'] == 0) {
                                                    ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512" style="display: inline-block ;">
                                                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                                        </svg>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 320 512" style="display: inline-block ;">
                                                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" />
                                                        </svg>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn border-0" data-bs-toggle="offcanvas" data-bs-target="#InfoOffcanvas" id="entry<?php echo $row['buchID']; ?>" aria-controls="InfoOffcanvas" data-id="entry<?php echo $row['buchID']; ?>" data-bookdata='<?php echo $row['buchID']; ?> # <?php echo $row['buch_titel']; ?> # <?php echo $row['buch_autor']; ?> # <?php echo $row['buch_ausgabe']; ?> # <?php echo $row['buch_bemerkung']; ?> # <?php echo $row['buch_kurzbeschrieb']; ?> # <?php echo $row['buch_nummer']; ?> # <?php echo $row['physisch'] ?> # <?php echo $row['virtuell'] ?> # <?php echo $row['ausgeliehen'] ?> # <?php echo $count;  ?>' onclick=InfoOffcanvas(this)>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 192 512">
                                                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path d="M144 80c0 26.5-21.5 48-48 48s-48-21.5-48-48s21.5-48 48-48s48 21.5 48 48zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z" />
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
            </div>
        </div>
        <div class="offcanvas offcanvas-start py-3 pe-3" tabindex="-1" id="InfoOffcanvas" aria-labelledby="InfoOffcanvasLabel">
            <div class="offcanvas-header pt-0">
                <p class="offcanvas-title" id="InfoOffcanvasLabel">
                </p>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="row">
                <p class="mb-0">Titel:</p>
                    <span id="buch_titel"></span>
                    <p class="mb-0 mt-3">Autor:</p>
                    <span id="buch_autor"></span>
                </div>
                <div class="row mt-3" style="height: 20hv;">
                    <div class="col-md-6">
                        <p class="mb-0">Nr:</p>
                        <span id="buch_nummer"></span>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-0 text-end">Ausgabe:</p>
                        <p class="text-end"><span id="buch_ausgabe"></span></p>

                    </div>
                </div>
                <div class="row d-grid gap-2 col-8 mx-auto mt-3">
                    <a type="button" class="btn btn-primary mx-auto" id="bookingbtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-0-circle" viewBox="0 0 448 512">
                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z" />
                        </svg>
                        Buch reservieren
                    </a>
                    <a type="button" class="btn btn-primary mx-auto mt-2" id="pdfbtn" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-0-circle" viewBox="0 0 384 512">
                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM64 224H88c30.9 0 56 25.1 56 56s-25.1 56-56 56H80v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V320 240c0-8.8 7.2-16 16-16zm24 80c13.3 0 24-10.7 24-24s-10.7-24-24-24H80v48h8zm72-64c0-8.8 7.2-16 16-16h24c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H176c-8.8 0-16-7.2-16-16V240zm32 112h8c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16h-8v96zm96-128h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H304v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H304v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V304 240c0-8.8 7.2-16 16-16z" />
                        </svg>
                        PDF öffnen
                    </a>
                </div>
            </div>
        </div>
    </div>



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

    <script>
        function InfoOffcanvas(entry) {
            const bookdata = entry.getAttribute("data-bookdata").split('#');
            document.getElementById("buch_titel").innerHTML = bookdata[1];
            document.getElementById("buch_autor").innerHTML = bookdata[2];
            document.getElementById("buch_ausgabe").innerHTML = bookdata[3];
            //document.getElementById("buch_bemerkung").innerHTML = bookdata[4];
            //document.getElementById("buch_kurzbeschrieb").innerHTML = bookdata[5];
            document.getElementById("buch_nummer").innerHTML = bookdata[6];


            var bookingbtn = document.getElementById("bookingbtn");
            var pdfbtn = document.getElementById("pdfbtn");

            if (bookdata[9] == 0) {
                bookingbtn.style.display = "block";
            } else {
                bookingbtn.style.display = "none";
            }

            if (bookdata[8] == 0) {
                pdfbtn.style.display = "none";
            } else {
                pdfbtn.style.display = "block";
            }
            bookingbtn.href = "booking.php?bookID=" + bookdata[0].trim();
            pdfbtn.href = "../pdf_view/web/viewer.php?pdfID=" + bookdata[6].trim() + ".pdf";

            // define carousel container
            var carousel = document.getElementById("carousel");

            // create an array of image URLs
            var imageUrls = [];
            imageUrls.push(bookdata[6].trim().concat(".jpg"));
            var manipulator = 1;
            console.log(bookdata)

            for (let i = 0; i < bookdata[10]; i++) {
                imageUrls.push(`${bookdata[6].trim()}_${manipulator}.jpg`)
                manipulator++;
            }

            console.log(imageUrls)

            for (var i = 0; i < imageUrls.length; i++) {
                // create a new carousel item element
                var item = document.createElement("div");
                item.classList.add("carousel-item");

                // create a new image element
                var carouselimg = document.createElement("img");
                carouselimg.setAttribute("src", "../../assets/images/book/".concat(imageUrls[i]));
                carouselimg.classList.add("d-block", "w-100");
                carouselimg.setAttribute("alt", "Slide Image " + i);

                // if it is first image
                if (i == 0) {
                    item.classList.add("active");
                }

                // append the image to the carousel item
                item.appendChild(carouselimg);
                //append the item to the carousel
                carousel.appendChild(item);
            }

        }
    </script>

</body>

</html>