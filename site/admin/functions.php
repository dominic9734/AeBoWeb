
<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

$username = $_SESSION["username"];

include "../../site/services/db_connect.php";



if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../services/login.php");
    exit;
}

if (session_id() == '') {
    session_start();
}

if (isset($_POST['delete_restore'])) {
    $buchID = htmlspecialchars($_POST['delete_restoreID']);

    $statement = $conn->prepare("SELECT geloescht FROM lib_books WHERE buchID = ? ");
    $statement->bind_param("i", $buchID);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();

    if ($row['geloescht'] == 0) {
        $statement = $conn->prepare('UPDATE lib_books SET geloescht = 1 WHERE buchID = ?');
        $statement->bind_param('i', $buchID);
        $statement->execute();
        header("location: books.php");
    } else {
        $statement = $conn->prepare('UPDATE lib_books SET geloescht = 0 WHERE buchID = ?');
        $statement->bind_param('i', $buchID);
        $statement->execute();
        header("location: archive.php");
    }
    exit;
}
//löscht mitarbeiter aus der db
if (isset($_POST['EmployeeDelete'])) {
    $EmployeeID = htmlspecialchars($_POST['DelEmployeeID']);
    $statement = $conn->prepare('DELETE FROM AeBo_employees WHERE employeeID = ?');
    $statement->bind_param('i', $EmployeeID);
    $statement->execute();
    header("location: employees.php");
    exit;
}
//setzt zugestellt in lib_borrowing auf 1
if (isset($_POST['deliver'])) {

    $ausleihID = htmlspecialchars($_POST['ausleihID']);
    $statement = $conn->prepare('UPDATE lib_borrowing SET zugestellt = 1 WHERE ausleihID = ?');
    $statement->bind_param('i', $ausleihID);
    $statement->execute();
    header("location: library.php");
    exit;

    //setzt zurückgegeben in lib_borrowing auf 1
}
//setzt bestell_status auf 1
if (isset($_POST['ordered'])) {

    $bestellID = htmlspecialchars($_POST['orderedID']);
    $statement = $conn->prepare('UPDATE lib_book_orders SET bestellung_status = 1 WHERE bestellungID = ?');
    $statement->bind_param('i', $bestellID);
    $statement->execute();
    header("location: order_book_library.php");
    exit;
}
//setzt zurükgegeben in lib_borrowing auf 1

if (isset($_POST['return'])) {

    $ausleihID = htmlspecialchars($_POST['ausleihID']);
    $buchID = htmlspecialchars($_POST['buchID']);

    $return_date = date("Y-m-d");


    $statement = $conn->prepare('UPDATE lib_borrowing SET zurueckgegeben = 1 WHERE ausleihID = ?');
    $statement->bind_param('i', $ausleihID);
    $statement->execute();

    $statement = $conn->prepare('UPDATE lib_books SET ausgeliehen = 0 WHERE buchID = ?');
    $statement->bind_param('i', $buchID);
    $statement->execute();

    $statement = $conn->prepare('UPDATE lib_borrowing SET rueckgabe_datum = ? WHERE ausleihID = ?');
    $statement->bind_param("si", $return_date, $ausleihID);
    $statement->execute();

    header("location: library.php");
    exit;
}
//importiert bücher in DB
if (isset($_POST['DataImport'])) {

    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    // Validate whether selected file is a CSV file
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

        // If the file is uploaded
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');


            fgets($csvFile);

            // Parse data from CSV file line by line
            while (($line = fgetcsv($csvFile)) !== FALSE) {
                // Get row data

                $line = array_map("utf8_encode", $line);

                $buch_nummer = $line[0];
                $buch_autor = $line[1];
                $buch_titel = $line[2];
                $buch_ausgabe = $line[3];
                $buch_bemerkung = $line[8];
                $buch_kurzbeschrieb = $line[9];

                //Check whether member already exists in the database with the same email
                $prevQuery = "SELECT buchID FROM lib_booksWHERE buch_nummer = '" . $line[0] . "'";
                $prevResult = $conn->query($prevQuery);


                if ($prevResult->num_rows > 0) {
                    // Update member data in the database
                    //$db->query("UPDATE lib_books SET buch_titel = '" . $buch_titel . "', buch_autor = '" . $buch_autor . "', buch_ausgabe = '" . $buch_ausgabe . "', modified = NOW() WHERE email = '" . $email . "'");

                    $statement = $conn->prepare('UPDATE lib_books SET  buch_nummer = ?,buch_titel = ?, buch_autor = ?, buch_ausgabe = ?, buch_bemerkung = ?, buch_kurzbeschrieb = ? where buchID = ?');
                    $statement->bind_param('ssssssi', $buch_nummer, $buch_titel, $buch_autor, $buch_ausgabe, $buch_bemerkung, $buch_kurzbeschrieb, $id);
                    $statement->execute();
                } else {
                    // Insert member data in the database
                    $statement = $conn->prepare('INSERT INTO lib_books (buch_nummer ,buch_titel , buch_autor , buch_ausgabe , buch_bemerkung , buch_kurzbeschrieb ) VALUES (?,?,?,?,?,?)');
                    $statement->bind_param('ssssss', $buch_nummer, $buch_titel, $buch_autor, $buch_ausgabe, $buch_bemerkung, $buch_kurzbeschrieb);
                    $statement->execute();
                    $statement->close();
                }
            }
            // Close opened CSV file
            fclose($csvFile);
            $qstring = '?status=succ';
        } else {
            $qstring = '?status=err';
        }
    } else {
        $qstring = '?status=invalid_file';
    }
    header("Location: library.php" . $qstring);
    exit;
}
if (isset($_POST['XMLExport'])) {
    exit;
}
//bearbeitet Mitarbeiter in excel
if (isset($_POST['UpdateEmployee'])) {

    $UpdateEmployeeID = htmlspecialchars($_POST['UpdateEmployeeID']);
    $UpdateEmployeeName = htmlspecialchars($_POST['UpdateEmployeeName']);
    $UpdateEmployeeKuerzel = htmlspecialchars($_POST['UpdateEmployeeKuerzel']);

    $statement = $conn->prepare("SELECT nickname FROM AeBo_employees WHERE employeeID = ?");
    $statement->bind_param('i', $UpdateEmployeeID);
    $statement->execute();
    $result = $statement->get_result();


    while ($row = $result->fetch_assoc()) {
        $EmployeeKuerzel = $row['nickname'];
    }

    $statement = $conn->prepare('UPDATE AeBo_employees SET  mitarbeitername = ?, nickname = ? where employeeID = ?');
    $statement->bind_param('ssi', $UpdateEmployeeName, $UpdateEmployeeKuerzel, $UpdateEmployeeID);
    $statement->execute();

    $currentDirectory = getcwd();
    $editDirecotry = "../../assets/images/employees_200px/";

    $updatepath = $currentDirectory . $editDirecotry;

    echo $updatepath . $EmployeeKuerzel . ".png";

    rename($updatepath . $EmployeeKuerzel . ".png", $updatepath . $UpdateEmployeeKuerzel . ".png");

    header("location: employees.php");

    exit;
}
//Mitarbeiter Erstellen
if (isset($_POST['CreateEmployee'])) {
    //start sql upload

    $Vorname = htmlspecialchars($_POST["Vorname"]);
    $Nachname = htmlspecialchars($_POST["Nachname"]);
    $nickname = htmlspecialchars($_POST["Kuerzel"]);

    $mitarbeitername = $Nachname . " " . mb_substr($Vorname, 0, 1) . ".";

    $statement = $conn->prepare("INSERT INTO AeBo_employees (mitarbeitername, nickname) VALUES(?,?)");
    $statement->bind_param("ss", $mitarbeitername, $nickname);
    $statement->execute();

    $target_file = $target_dir . basename($_FILES["File"]["name"]);

    $currentDirectory = getcwd();
    $uploadDirectory = htmlspecialchars($_POST['Directory']);

    $fileExtensionsAllowed = 'png';

    $fileName = $_FILES['File']['name'];
    $fileSize = $_FILES['File']['size'];
    $fileTmpName  = $_FILES['File']['tmp_name'];
    $fileType = $_FILES['File']['type'];
    $fileExtension = strtolower(end(explode('.', $fileName)));

    if ($fileExtensionsAllowed == $fileExtension) {
        $NewFileName = $nickname . "." . $fileExtension;

        $uploadPath = $currentDirectory . $uploadDirectory . basename($NewFileName);
        $uploaded = move_uploaded_file($fileTmpName, $uploadPath);
        header("location: employees.php");
    } else {
        $UploadError = 1;
        header("location: employees.php");
    }
    exit;
}
//Mmitarbeiter CSV export
if (isset($_GET['ExportCSV'])) {
    $query = $conn->query("SELECT * FROM AeBo_employees ORDER BY employeeID ASC");
    if ($query->num_rows > 0) {
        $delimiter = ",";
        $filename = "Export_MA_AEBOLIB_" . date('Y-m-d') . ".csv";

        $f = fopen('php://memory', 'w');

        $fields = array('employeeID', 'mitarbeitername', 'nickname');
        fputcsv($f, $fields, $delimiter);


        while ($row = $query->fetch_assoc()) {
            $lineData = array($row['employeeID'], $row['mitarbeitername'], $row['nickname']);
            $lineData = array_map("utf8_decode", $lineData);
            fputcsv($f, $lineData, $delimiter);
        }
        fseek($f, 0);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        fpassthru($f);
    }
    exit;
}
//Mitarbeiter CSV import
if (isset($_POST['ImportCSV'])) {
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    // Validate whether selected file is a CSV file
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {
        // If the file is uploaded
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            for ($i = 1; $i <= 21; $i++) {
                fgetcsv($csvFile);
            }

            // Parse data from CSV file line by line
            while (($line = fgetcsv($csvFile, 0)) !== FALSE) {
                $first_name = $line[3];
                $last_name = $line[2];
                $nickname = $line[4];
                $location = $line[5];
                $zone = $line[6];
                $work_division = $line[7];
                $internal_phone = $line[8];
                $mobile_phone = $line[9];
                $primary_mail = $line[10];
                $special_authority = $line[11];
                $department = $line[12];


                $stmt = $conn->prepare('SELECT nickname FROM AeBo_employees WHERE BINARY nickname = ?');
                $stmt->bind_param("s", $nickname);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows == 0 && !empty($first_name && $last_name)) {
                    $stmt = $conn->prepare('INSERT INTO AeBo_employees (first_name , last_name, nickname, location, zone, work_division, internal_phone, mobile_phone,primary_mail,special_authority,department) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
                    $stmt->bind_param('sssssssssss', $first_name, $last_name, $nickname, $location, $zone, $work_division, $internal_phone, $mobile_phone, $primary_mail, $special_authority, $department);
                    $stmt->execute();
                } elseif (!empty($first_name && $last_name)) {
                    $stmt = $conn->prepare('UPDATE AeBo_employees SET first_name = ?, last_name = ?, location = ?, zone = ?, work_division = ?, internal_phone = ?, mobile_phone = ? , primary_mail = ?,special_authority = ?,department = ? WHERE BINARY nickname = ?');
                    $stmt->bind_param('ssssssssssss', $first_name, $last_name, $location, $zone, $work_division, $internal_phone, $mobile_phone, $primary_mail, $special_authority, $department, $nickname, $nickname);
                    $stmt->execute();
                }
            }
            // Close opened CSV file
            fclose($csvFile);
            $qstring = '?status=succ';
        }
    } else {
        $qstring = '?status=err';
    }
    header("Location: employees.php" . $qstring);
    exit;
}
//export DB zu CSV
if (isset($_POST['ExportBook'])) {
    $query = $conn->query("SELECT * FROM lib_booksORDER BY buchID ASC");
    if ($query->num_rows > 0) {
        $delimiter = ",";
        $filename = "Export_AeBo_DB_" . date('Y-m-d') . ".csv";

        $f = fopen('php://memory', 'w');

        $fields = array('ID', 'Buch_Nummer', 'Buch_Autor', 'Buch_Titel', 'Buch_Ausgabe', 'Buch_Bemerkung', 'Buch_Kurzbeschrieb', 'ausgeliehen_stats', 'geloescht_status');
        fputcsv($f, $fields, $delimiter);


        while ($row = $query->fetch_assoc()) {
            $lineData = array($row['buchID'], $row['buch_nummer'], $row['buch_autor'], $row['buch_titel'], $row['buch_ausgabe'], $row['buch_bemerkung'], $row['buch_kurzbeschrieb'], $row['ausgeliehen'], $row['geloescht'],);
            $lineData = array_map("utf8_decode", $lineData);
            fputcsv($f, $lineData, $delimiter);
        }
        fseek($f, 0);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        fpassthru($f);
    }
    exit;
}



// Buch hinzufügen daten zu DB bild zu ordner
if (isset($_POST['AddBook'])) {

    //buch werte in DB
    $buch_nummer = htmlspecialchars($_POST["buch_nummer"]);
    $buch_titel = htmlspecialchars($_POST["buch_titel"]);
    $buch_autor = htmlspecialchars($_POST["buch_autor"]);
    $buch_ausgabe = htmlspecialchars($_POST["buch_ausgabe"]);
    $buch_bemerkung = htmlspecialchars($_POST["buch_bemerkung"]);
    $buch_kurzbeschrieb = htmlspecialchars($_POST["kurzbeschrieb"]);
    $physisch  = htmlspecialchars($_POST["physisch"]);
    $virtuell  = htmlspecialchars($_POST["virtuell"]);

    $statement = $conn->prepare("INSERT INTO lib_books (buch_nummer,buch_titel, buch_autor, buch_ausgabe, buch_bemerkung, buch_kurzbeschrieb, physisch, virtuell) VALUES(?,?,?,?,?,?,?,?)");
    $statement->bind_param("ssssssii", $buch_nummer, $buch_titel, $buch_autor, $buch_ausgabe, $buch_bemerkung, $buch_kurzbeschrieb, $physisch, $virtuell);
    $statement->execute();
    $statement->close();
    $conn->close();


    $currentDirectory = getcwd();
    $uploadDirectoryPDF = htmlspecialchars($_POST['DirectoryPDF']);
    $uploadDirectoryJPG = htmlspecialchars($_POST['DirectoryBook']);

    //PDF in ordner
    $fileExtensionsAllowedPDF = 'pdf';
    $fileNamePDF = $_FILES['pdf_file']['name'];
    $fileTmpNamePDF  = $_FILES['pdf_file']['tmp_name'];
    $fileExtensionPDF = strtolower(end(explode('.', $fileNamePDF)));

    $statusstr = "?status=succ";

    if ($fileExtensionsAllowedPDF == $fileExtensionPDF) {
        $NewFileNamePDF = $buch_nummer . "." . $fileExtensionPDF;
        $uploadPathPDF = $currentDirectory . $uploadDirectoryPDF . basename($NewFileNamePDF);
        $uploaded = move_uploaded_file($fileTmpNamePDF, $uploadPathPDF);
    } else {
        $statzsstr = "?status=err";
    }
    header("Location: books.php" . $statusstr);
    exit;
}
// Buch uopdate daten in DB neues bild zu ordner
if (isset($_POST['EditBook'])) {
    $buchID = htmlspecialchars($_POST['buchID']);
    $buch_nummer = htmlspecialchars($_POST['buch_nummer']);
    $buch_titel = htmlspecialchars($_POST['buch_titel']);
    $buch_autor = htmlspecialchars($_POST['buch_autor']);
    $buch_ausgabe = htmlspecialchars($_POST['buch_ausgabe']);
    $buch_bemerkung = htmlspecialchars($_POST['buch_bemerkung']);
    $buch_kurzbeschrieb = htmlspecialchars($_POST['kurzbeschrieb']);
    $statement = $conn->prepare('UPDATE lib_books SET  buch_nummer = ?,buch_titel = ?, buch_autor = ?, buch_ausgabe = ?, buch_bemerkung = ?, buch_kurzbeschrieb = ? where buchID = ?');

    $statement->bind_param('ssssssi', $buch_nummer, $buch_titel, $buch_autor, $buch_ausgabe, $buch_bemerkung, $buch_kurzbeschrieb, $buchID);
    $statement->execute();

    //pdf update
    $fileExtensionsAllowedPDF = 'pdf';
    $currentDirectory = getcwd();
    $uploadDirectoryPDF = htmlspecialchars($_POST['DirectoryPDF']);

    $fileNamePDF = $_FILES['pdf_file']['name'];
    $fileTmpNamePDF  = $_FILES['pdf_file']['tmp_name'];
    $fileExtensionPDF = strtolower(end(explode('.', $fileNamePDF)));

    $statusstr = "?status=succ";
    //header("location:books.php");
    exit;
}
if (isset($_POST['AddMagazine'])) {
    //buch werte in DB
    $magazine_title = htmlspecialchars($_POST["magazine_title"]);
    $magazine_autor = htmlspecialchars($_POST["magazine_autor"]);
    $magazine_edition_j = htmlspecialchars($_POST["magazine_edition_j"]);
    $magazine_edition = htmlspecialchars($_POST["magazine_edition"]);

    $statement = $conn->prepare("INSERT INTO lib_magazines (magazine_title,magazine_autor,magazine_edition_j,magazine_edition) VALUES(?,?,?,?)");
    $statement->bind_param("ssii", $magazine_title, $magazine_autor, $magazine_edition_j, $magazine_edition);
    $statement->execute();
    $statement->close();
    $conn->close();
    /*
    $currentDirectory = getcwd();
    $CoverDirectory = htmlspecialchars($_POST['CoverDirectory']);

    //PDF in ordner
    $fileExtensionsAllowedPDF = 'pdf';
    $fileNamePDF = $_FILES['pdf_file']['name'];
    $fileTmpNamePDF  = $_FILES['pdf_file']['tmp_name'];
    $fileExtensionPDF = strtolower(end(explode('.', $fileNamePDF)));

    $statusstr = "?status=succ";

    if ($fileExtensionsAllowedPDF == $fileExtensionPDF) {
        $NewFileNamePDF = $buch_nummer . "." . $fileExtensionPDF;
        $uploadPathPDF = $currentDirectory . $uploadDirectoryPDF . basename($NewFileNamePDF);
        $uploaded = move_uploaded_file($fileTmpNamePDF, $uploadPathPDF);
    } else {
        $statzsstr = "?status=err";
    }
    */
    header("Location: magazines.php" . $statusstr);
    exit;
}
if (isset($_POST['delete_restore_mag'])) {
    $magazineID = htmlspecialchars($_POST['delete_restoreID']);

    $statement = $conn->prepare("SELECT isDeleted FROM lib_magazines WHERE magazineID = ? ");
    $statement->bind_param("i", $buchID);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();

    if ($row['geloescht'] == 0) {
        $statement = $conn->prepare('UPDATE lib_magazines SET isDeleted = 1 WHERE magazineID = ?');
        $statement->bind_param('i', $buchID);
        $statement->execute();
        header("location: magazine.php");
    } else {
        $statement = $conn->prepare('UPDATE lib_magazines SET isDeleted = 0 WHERE magazineID = ?');
        $statement->bind_param('i', $buchID);
        $statement->execute();
        header("location: magazine.php");
    }
    exit;
}

if (isset($_POST['EditMagazine'])) {
    $newFile = $_FILES['edit_cover'];

    $statement = $conn->prepare('SELECT magazine_image FROM lib_magazines WHERE magazineID = ?');
    $statement->bind_param('i', $_POST['magazineID']);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();

    if (!is_null($row['magazine_image'])) {
        $delete_file = getcwd() . "/" . $row['magazine_image'];
        unlink(realpath($delete_file));
    }

    $magazine_db_filename ="../../assets/images/img/cover_mag_" . $_POST['magazineID']."_" . time() . ".png";

    $statement = $conn->prepare('UPDATE lib_magazines SET magazine_image = ? WHERE magazineID = ?');
    $statement->bind_param('si', $magazine_db_filename, $_POST['magazineID']);
    $statement->execute();

    $magazine_newfilename = getcwd() . "/../../assets/images/img/cover_mag_" . $_POST['magazineID']."_" . time() . ".png";

    move_uploaded_file($newFile['tmp_name'], $magazine_newfilename);


    $magazineID = htmlspecialchars($_POST['magazineID']);
    $magazine_title = htmlspecialchars($_POST['magazine_title']);
    $magazine_autor = htmlspecialchars($_POST['magazine_autor']);
    $magazine_edition_j = htmlspecialchars($_POST['magazine_edition_j']);
    $magazine_edition = htmlspecialchars($_POST['magazine_edition']);


    $statement = $conn->prepare('UPDATE lib_magazines SET  magazine_title = ?,magazine_autor = ?, magazine_edition_j = ?, magazine_edition = ? where magazineID = ?');
    $statement->bind_param('ssssi', $magazine_title, $magazine_autor, $magazine_edition_j, $magazine_edition, $magazineID);
    $statement->execute();


    header("location:magazines.php");
    exit;
}

?>