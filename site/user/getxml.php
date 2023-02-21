<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AEBO-Library</title>
    <link rel="icon" type="image/x-icon" href="../../assets/svg/favicon.svg">

    <link href=../../assets/vendor/bootstrap/bootstrap.min.css rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style/style.css">

    <style>
        p {
            margin-top: 30px;
            margin-bottom: 30px;
        }

        /* Some basic styles to make the dropdown menu look nice */

        .background {
            background: #ce0145;
            color: #ffffff;
        }

        .chip-wrapper {
            width: 100%;
            overflow-x: scroll;
            overflow-y: hidden;
            white-space: nowrap;
            padding-bottom: 12px;
        }

        .chip {
            padding: 5px 10px;
            border-radius: 50px;
            margin: 5px;
            min-width: 75px;
            display: inline-block;
        }

        .closebtn {
            padding-left: 10px;
            color: #ffffff;
            font-weight: bold;
            float: right;
            font-size: 20px;
            cursor: pointer;
        }

        .closebtn:hover {
            color: #e6e6e6;
        }

        input[type="checkbox"]:hover,
        label:hover {
            cursor: pointer;
            user-select: none;
        }
    </style>

</head>

<body>
    <?php
    $showSearch = false;
    $showEmpDatalist = false;
    include "../services/nav_index.php";
    setnavvalues($showSearch, $showEmpDatalist); ?>

    <div class="d-flex justify-content-center">
        <div class="info-container mt-5" style="width: 70vw;">
            <h1 class="fw-bold">Literaturverzeichnis</h1>
            <p>Die Bibliografie-Funktion von Microsoft Word ermöglicht es, Quellen einfach zu erstellen und zu verwalten. Quellen können manuell hinzugefügt werden, indem man Zitierinformationen eingibt oder extern bezieht. Zitierinformationen stehen auf dieser Seite zum Download zur Verfügung.</p>
            <h2 class="fw-bold">Zitierinformationen Download</h2>
            <p>Wählen Sie die gewünschten Bücher, welche sie dem Verzeichnis hinzufügen wollen und laden sie die .xml Datei herunter.</p>
            <div class="highlight">
            </div>


            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    Auswahl
                </button>
                <ul class="dropdown-menu p-2 height-40hv overflow-auto w-100 border-0">
                    <li>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Suchen..." aria-label="Suchen..." id="SearchBar">
                        </div>

                    </li>
                    <div id="DropdownSearchContent">
                        <li>
                            <div class="form-check align-middle">
                                <input class="form-check-input" id="CheckboxMainSwitch" type="checkbox" value="Alle">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Alle
                                </label>
                            </div>
                        </li>
                        <?php
                        include "../../site/services/db_connect.php";

                        $statement = $conn->prepare("SELECT * from lib_xml_filters");
                        $statement->execute();
                        $result = $statement->get_result();
                        if ($result->num_rows != 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <li>
                                    <div class="form-check form-check-inline align-middle">
                                        <input class="form-check-input" id="entry<?php echo $row['filterID'] ?>" type="checkbox" value="<?php echo $row['filterID'] ?>" onchange="storeValues()">
                                        <label class="form-check-label" for="entry<?php echo $row['filterID'] ?>">
                                            <?php echo $row['filter_number'] ?> - <?php echo $row['filter_name'] ?>
                                        </label>
                                    </div>
                                </li>

                        <?php
                            }
                        }
                        ?>
                    </div>
                </ul>
            </div>
            <div id="chip-wrapper" class="my-2 chip-wrapper">
            </div>
            <form action="../services/xml.php" method="post">
                <input hidden type="text" name="XmlSelection" id="XmlSelection" value="">
                <div class="input-group mb-3" id="DownloadSection">
                    <button class="btn btn-outline-success " type="submit" id="download">Download</button>
                    <input type="text" class="form-control" aria-label="" aria-describedby="" value="Sources_AEBO_<?php echo date("d_m_Y"); ?>.xml" disabeled>
                </div>
            </form>
            <h2 class="fw-bold">How-To</h2>
            <h2 class="fw-bold pt-2">1.</h2>
            <p class="mt-1">Im ersten Schritt laden Sie die gewünschten Informationen mit dem überliegenden Button herunter. Sie können die .xml Datei entweder an einen beliebigen Ort oder unter dem MS Word "Bibliography" Verzeichnis ablegen. Um zum "Bibliography" Verzeichnis zu gelangen, drücken Sie "<svg style="padding-bottom: 4px;" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path d="M0 93.7l183.6-25.3v177.4H0V93.7zm0 324.6l183.6 25.3V268.4H0v149.9zm203.8 28L448 480V268.4H203.8v177.9zm0-380.6v180.1H448V32L203.8 65.7z" />
                </svg> + R" und fügen sie den unterliegenden Pfad ein.</p>
            <div class="combobox">
                <input type="text" value="%appdata%\Microsoft\Bibliography" id="CopyToClipboard" readonly>
                <button class="CopyToClipboard_btn" onclick="CopyToClipboard()" data-bs-toggle="tooltip" data-bs-title="Kopieren">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                        <path d="M280 64h40c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128C0 92.7 28.7 64 64 64h40 9.6C121 27.5 153.3 0 192 0s71 27.5 78.4 64H280zM64 112c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V128c0-8.8-7.2-16-16-16H304v24c0 13.3-10.7 24-24 24H192 104c-13.3 0-24-10.7-24-24V112H64zm128-8a24 24 0 1 0 0-48 24 24 0 1 0 0 48z" />
                    </svg>
                </button>
            </div>
            <h2 class="fw-bold pt-2">2.</h2>
            <p class="mt-4">Anschliessend öffnen sie MS Word und klicken sie auf "Verweise".</p>
            <img src="../../assets/images/img/xml_step_1.jpeg" class="img-fluid rounded mb-3 xml_img" alt="...">
            <h2 class="fw-bold pt-2">3.</h2>
            <p class="mt-1">In dem Tab "Verweise", klicken sie auf "Quellen verwalten".</p>
            <img src="../../assets/images/img/xml_step_2.jpeg" class="img-fluid rounded mb-3 xml_img" alt="...">
            <h2 class="fw-bold pt-2">4.</h2>
            <p class="mt-1">In dem sich öffnenden Fenster, klicken Sie auf "Durchsuchen".</p>
            <img src="../../assets/images/img/xml_step_2.5.jpeg" class="img-fluid rounded mb-3 xml_img" alt="...">
            <h2 class="fw-bold pt-2">5.</h2>
            <p class="mt-1">Es öffnet sich ein Explorer Fenster im oben beschriebenen "Biography" Verzeichnis, sollten sie ihre .xml Datei an einem anderen Ort abgespeichert haben, navigieren sie zu dem Ort; wie hier "Downloads".</p>
            <p>Klicken Sie ihre .xml Datei an und klicken Sie auf "OK".</p>
            <img src="../../assets/images/img/xml_step_3.jpeg" class="img-fluid rounded mb-3 xml_img" alt="...">
            <h2 class="fw-bold pt-2">6.</h2>
            <p class="mt-1">Das Explorer Fenster schliesst sich und Sie haben die Literaturliste der .xml Datei MS Word zur Verfügung gestellt. Nun müssen Sie die gewünschten Bücher markieren und anschliessend auf "Kopieren" klicken.</p>
            <p>Anschliessend können sie auf "Schliessen" Klicken um den Vorgang abzuschliessen</p>
            <img src="../../assets/images/img/xml_step_5.jpeg" class="img-fluid rounded mb-3 xml_img" alt="...">
            <h2 class="fw-bold pt-2">7.</h2>
            <p class="mt-1">Verwenden Sie die hinzugefügen Buchzitate indem sie im Tab "Verweise" auf "Zitat einfügen" Klicken und ihr gewünschtes Buch auswählen.</p>
            <img src="../../assets/images/img/xml_step_6.jpeg" class="img-fluid rounded mb-3 xml_img" alt="...">
        </div>
    </div>



    <?php include "../services/footer.php"; ?>

    <!--  Bootstrap -->
    <script src="../../assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="../../assets/vendor/jquery/jquery-3.5.1.js"></script>
    <!-- Datatables -->
    <script src="../../assets/vendor/datatables/datatables.min.js"></script>
    <!--Loading screen-->
    <script src="../../assets/vendor/js/loading.js"></script>

    <script language="JavaScript">
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

    <script language="JavaScript">
        // Create an empty array to store the checkbox values
        const CheckboxValues = [];
        //CheckboxValues.splice(0, CheckboxValues.length);

        // Get all the checkbox elements on the page
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');

        // Loop through all the checkboxes and set them to unchecked
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
        }

        // Define download button location
        const DownloadSection = $('#DownloadSection');
        DownloadSection.hide()

        function RemoveChip(element) {
            let CheckboxID = element.dataset.value;
            const SwitchChipCheckbox = document.getElementById(CheckboxID);
            SwitchChipCheckbox.checked = false;
            storeValues();


        }

        // Function to store the checked values in the array
        function storeValues() {
            // Clear the values array by removing all its elements
            CheckboxValues.splice(0, CheckboxValues.length);

            // Get all the checkboxes in the content wrapper
            const checkboxes = document.querySelectorAll(".form-check-input");
            const div = document.getElementById("chip-wrapper");

            //removed all children in chip-wrapper
            while (div.firstChild) {
                div.removeChild(div.firstChild);
            }

            // Loop through the checkboxes and add their CheckboxValues to the array
            Array.from(checkboxes).forEach((checkbox) => {
                if (checkbox.checked && checkbox.value !== "Alle") {
                    CheckboxValues.push(checkbox.value);

                    // Create a chip element with the checkbox value as its inner HTML
                    const chip = document.createElement('div');
                    chip.className = 'chip background';
                    chip.innerHTML = checkbox.value;

                    // Create a close button for the chip
                    const CloseChip = document.createElement('span');
                    CloseChip.className = "CloseBtn";
                    CloseChip.innerHTML = "&times;";
                    CloseChip.setAttribute("data-value", "entry" + checkbox.value);
                    CloseChip.setAttribute("onclick", "RemoveChip(this)");

                    // Add the chip to the chip-wrapper element
                    div.appendChild(chip);
                    chip.appendChild(CloseChip);
                }
            });

            // Hide or show Download Button based on if array "CheckboxValues" has a length greater than 0 or not
            if (CheckboxValues.length > 0) {
                DownloadSection.show();
            } else {
                DownloadSection.hide();
            }

            var jsonString = JSON.stringify(CheckboxValues);
            document.getElementById("XmlSelection").setAttribute('value', jsonString);
        }


        function CopyToClipboard() {
            // Get the text field
            var copyText = document.getElementById("CopyToClipboard");

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);
        }

        let selectAll = document.getElementById("CheckboxMainSwitch");
        let CheckSwitch = document.querySelectorAll(".form-check-input");

        selectAll.addEventListener("change", function() {
            CheckSwitch.forEach(box => {
                box.checked = selectAll.checked;
                storeValues();
            });
        });

        const searchBar = document.getElementById('SearchBar');
        const contentWrapper = document.getElementById('DropdownSearchContent');

        searchBar.addEventListener('input', () => {
            const query = searchBar.value.toLowerCase();
            Array.from(contentWrapper.children).forEach(div => {
                div.style.display = div.textContent.toLowerCase().includes(query) ? 'block' : 'none';
            });
        });
    </script>

</body>

</html>