
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
    $bookID = htmlspecialchars($_POST['delete_restoreID']);

    $statement = $conn->prepare("SELECT deleted FROM lib_books WHERE bookID = ? ");
    $statement->bind_param("i", $bookID);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();

    if ($row['deleted'] == 0) {
        $statement = $conn->prepare('UPDATE lib_books SET deleted = 1 WHERE bookID = ?');
        $statement->bind_param('i', $bookID);
        $statement->execute();
        header("location: books.php");
    } else {
        $statement = $conn->prepare('UPDATE lib_books SET deleted = 0 WHERE bookID = ?');
        $statement->bind_param('i', $bookID);
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

    $junctionID = htmlspecialchars($_POST['junctionID']);
    echo $junctionID;
    $statement = $conn->prepare('UPDATE junction_books SET deliver_date = ?, delivered = 1 WHERE junctionID = ?');
    $statement->bind_param('si', date("Y-m-d"), $junctionID);
    $statement->execute();
    header("location: library.php");
    exit;

    //setzt zurückgegeben in lib_borrowing auf 1
}
//setzt bestell_status auf 1
if (isset($_POST['ordered'])) {
    $statement = $conn->prepare('UPDATE lib_book_orders SET orderstatus = 1  WHERE orderID = ?');
    $statement->bind_param('i', $_POST['orderID']);
    $statement->execute();
    header("location: order_book_library.php");
    exit;
}
//setzt zurükgegeben in lib_borrowing auf 1

if (isset($_POST['return'])) {

    $junctionID = htmlspecialchars($_POST['junctionID']);
    $bookID = htmlspecialchars($_POST['bookID']);

    echo $bookID;

    $statement = $conn->prepare('UPDATE junction_books SET returned = 1 WHERE junctionID = ?');
    $statement->bind_param('i', $junctionID);
    $statement->execute();

    $statement = $conn->prepare('UPDATE lib_books SET borrowed = 0 WHERE bookID = ?');
    $statement->bind_param('i', $bookID);
    $statement->execute();

    $statement = $conn->prepare('UPDATE junction_books SET returned_date = ? WHERE junctionID = ?');
    $statement->bind_param("si", date("Y-m-d"), $junctionID);
    $statement->execute();

    header("location: library.php");
    exit;
}
if (isset($_POST['XMLExport'])) {
    exit;
}
// -------------- IPA--------------
// update employees into the database

/*
Function Name: updateEmployee
Description: Updates an employee entry in the database and renames associated image file
Author: D.Leuthardt
Parameters: 
UpdateEmployee (IN) - HTTP GET parameter to trigger the export functionality
Returns: None
Modification History:

Purpose:
This function is triggered when the "UpdateEmployee" button is pressed in the employee editing form.
It retrieves the updated employee data from the HTTP POST request and updates the corresponding database entry using an SQL query.
The function then renames the associated employee image file to match the new employee nickname.
Finally, the function redirects the user to the employees.php page.
*/

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

    $statement = $conn->prepare('UPDATE AeBo_employees SET  nickname = ?, nickname = ? where employeeID = ?');
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

/*
Function Name: createEmployee
Description: Inserts a new employee entry into the database with associated image file
Author: D.Leuthardt
Parameters:
CreateEmployee (IN) - HTTP GET parameter to trigger the export functionality
Returns: None
Modification History:

Purpose:
This function is triggered when the "CreateEmployee" button is pressed in the employee creation form.
It retrieves the new employee data from the HTTP POST request and inserts it as a new entry in the database using an SQL query.
The function also uploads the associated employee image file to the appropriate directory.
Finally, the function redirects the user to the employees.php page.
*/

if (isset($_POST['CreateEmployee'])) {

    $employeeimage = $_FILES['employeeimage'];

    $employeeimagepath = "employeeimage_" . uniqid() . ".png";

    $statement = $conn->prepare("INSERT INTO AeBo_employees (first_name, last_name, nickname, location, zone, work_division, internal_phone, mobile_phone, primary_mail, special_authority, department,employee_image) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
    $statement->bind_param("ssssssssssss", $_POST["first_name_input"], $_POST["last_name_input"], $_POST["nickname_input"], $_POST["location_input"], $_POST["zone_input"], $_POST["work_division_input"], $_POST["internal_phone_input"], $_POST["mobile_phone_input"], $_POST["primary_mail_input"], $_POST["special_authority_input"], $_POST["department_input"], $employeeimagepath);
    $statement->execute();

    move_uploaded_file($employeeimage['tmp_name'], getcwd() . "/../../assets/images/employees_200px/" . $employeeimagepath);
    header("Location: employees.php");
    exit;
}
/*
Function Name: createEmployee
Project: aeboWeb
Description: Generates a CSV file containing employee data and sends it as an attachment in a HTTP response
Author: D.Leuthardt
Parameters:
ExportCSV (IN) - HTTP GET parameter to trigger the export functionality
Returns: None
Modification History:

Purpose:
This function generates a CSV file containing employee data based on a SQL query that retrieves employee information from a database.
The resulting CSV file is sent as an attachment in a HTTP response with appropriate headers.
*/
if (isset($_GET['ExportCSV'])) {
    $query = $conn->query("SELECT * FROM AeBo_employees ORDER BY employeeID ASC");
    if ($query->num_rows > 0) {
        $delimiter = ",";
        $csvuploadfilename = "Export_MA_AEBOLIB_" . date('Y-m-d') . ".csv";

        $csvupload = fopen('php://memory', 'w');

        $fields = array('employeeID', 'first_name', 'last_name', 'nickname', 'location', 'zone', 'work_division', 'internal_phone', 'mobile_phone', 'primary_mail', 'special_authority', 'department', 'employee_image');
        fputcsv($csvupload, $fields, $delimiter);


        while ($row = $query->fetch_assoc()) {
            $lineData = array($row['employeeID'], $row['first_name'], $row['last_name'], $row['nickname'], $row['location'], $row['zone'], $row['work_division'], $row['internal_phone'], $row['mobile_phone'], $row['primary_mail'], $row['special_authority'], $row['department'], $row['employee_image']);
            $lineData = array_map("utf8_decode", $lineData);
            fputcsv($csvupload, $lineData, $delimiter);
        }
        fseek($csvupload, 0);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $csvuploadfilename . '";');

        fpassthru($csvupload);
    }
    exit;
}
/*
Function Name: ExportCSV
Project: aeboWeb
Description: Imports employee data from a CSV file and inserts or updates the data in a database
Author: D.Leuthardt
Parameters:
ImportCSV (IN) - HTTP POST parameter to trigger the import functionality
Returns: None
Modification History:

Purpose:
This function imports employee data from a CSV file and inserts or updates the data in a database.
It first validates the selected file to ensure it is a CSV file, then parses the data line by line and retrieves the employee information from each line.
It then checks if an employee with the same nickname already exists in the database and either inserts a new record or updates the existing record.
The function redirects back to the employees.php page after completion with appropriate status messages.
*/
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
                $employee_image = $line[13];


                $stmt = $conn->prepare('SELECT nickname FROM AeBo_employees WHERE BINARY nickname = ?');
                $stmt->bind_param("s", $nickname);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows == 0 && !empty($first_name && $last_name)) {
                    $stmt = $conn->prepare('INSERT INTO AeBo_employees (first_name , last_name, nickname, location, zone, work_division, internal_phone, mobile_phone,primary_mail,special_authority,department) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)');
                    $stmt->bind_param('ssssssssssss', $first_name, $last_name, $nickname, $location, $zone, $work_division, $internal_phone, $mobile_phone, $primary_mail, $special_authority, $department, $employee_image);
                    $stmt->execute();
                } elseif (!empty($first_name && $last_name)) {
                    $stmt = $conn->prepare('UPDATE AeBo_employees SET first_name = ?, last_name = ?, location = ?, zone = ?, work_division = ?, internal_phone = ?, mobile_phone = ? , primary_mail = ?,special_authority = ?,department = ?,employee_image = ? WHERE BINARY nickname = ?');
                    $stmt->bind_param('sssssssssssss', $first_name, $last_name, $location, $zone, $work_division, $internal_phone, $mobile_phone, $primary_mail, $special_authority, $department, $nickname, $nickname, $employee_image);
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


// --------------END IPA--------------

//export all book data to csv
if (isset($_GET['BookCSV'])) {

    $query = $conn->query("SELECT * FROM lib_books ORDER BY bookID ASC");
    if ($query->num_rows > 0) {
        $delimiter = ",";
        $filename = "Export_BESTAND_AEBOLIB_" . date('Y-m-d') . ".csv";

        $f = fopen('php://memory', 'w');

        $fields = array('ID', 'book_number', 'book_autor', 'book_title', 'book_edition', 'book_comment', 'book_aditionalinfo', 'format_hardcover', 'format_pdf', 'borrowed_stats', 'deleted_status');
        fputcsv($f, $fields, $delimiter);

        while ($row = $query->fetch_assoc()) {
            $lineData = array($row['bookID'], $row['book_number'], $row['book_autor'], $row['book_title'], $row['book_edition'], $row['book_comment'], $row['book_aditionalinfo'], $row['format_hardcover'], $row['format_pdf'], $row['borrowed'], $row['deleted']);
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

//importiert bücher in DB
if (isset($_POST['BookCSVImport'])) {

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

                $bookID = $line[0];
                $book_number = $line[1];
                $book_autor = $line[2];
                $book_title = $line[3];
                $book_edition = $line[4];
                $book_comment = $line[5];
                $book_aditionalinfo = $line[6];
                $format_hardcover = $line[7];
                $format_pdf = $line[8];
                $borrowed = $line[9];
                $deleted = $line[10];

                //Check whether member already exists in the database with the same email
                $prevQuery = "SELECT bookID FROM lib_books WHERE book_number =  $line[1]";
                $prevResult = $conn->query($prevQuery);


                if ($prevResult->num_rows > 0) {
                    $statement = $conn->prepare('UPDATE lib_books SET book_title= ?, book_autor = ?, book_edition = ?, book_comment = ?, book_aditionalinfo = ?,format_hardcover = ?,format_pdf = ?,borrowed = ?, deleted = ? where book_number = ?');
                    $statement->bind_param('sssssiiiis', $book_title, $book_autor, $book_edition, $book_comment, $book_aditionalinfo, $format_hardcover, $format_pdf, $borrowed, $deleted, $book_number);
                    $statement->execute();
                } else {
                    // Insert member data in the database
                    $statement = $conn->prepare('INSERT INTO lib_books (book_number ,book_title, book_autor , book_edition , book_comment , book_aditionalinfo,format_hardcover,format_pdf,borrowed,deleted ) VALUES (?,?,?,?,?,?,?,?,?,?)');
                    $statement->bind_param('ssssssiiii', $book_number, $book_title, $book_autor, $book_edition, $book_comment, $book_aditionalinfo, $format_hardcover, $format_pdf, $borrowed, $deleted);
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
    header("Location: books.php" . $qstring);
    exit;
}



// Buch hinzufügen daten zu DB bild zu ordner
if (isset($_POST['AddBook'])) {

    //buch werte in DB
    $book_number = htmlspecialchars($_POST["book_number"]);
    $book_title = htmlspecialchars($_POST["book_title"]);
    $book_autor = htmlspecialchars($_POST["book_autor"]);
    $book_edition = htmlspecialchars($_POST["book_edition"]);
    $book_comment = htmlspecialchars($_POST["book_comment"]);
    $book_aditionalinfo = htmlspecialchars($_POST["kurzbeschrieb"]);
    $format_hardcover  = htmlspecialchars($_POST["format_hardcover"]);
    $format_pdf  = htmlspecialchars($_POST["format_pdf"]);

    $statement = $conn->prepare("INSERT INTO lib_books (book_number,book_title, book_autor, book_edition, book_comment, book_aditionalinfo, format_hardcover, format_pdf) VALUES(?,?,?,?,?,?,?,?)");
    $statement->bind_param("ssssssii", $book_number, $book_title, $book_autor, $book_edition, $book_comment, $book_aditionalinfo, $format_hardcover, $format_pdf);
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
        $NewFileNamePDF = $book_number . "." . $fileExtensionPDF;
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
    $bookID = htmlspecialchars($_POST['bookID']);
    $book_number = htmlspecialchars($_POST['book_number']);
    $book_title = htmlspecialchars($_POST['book_title']);
    $book_autor = htmlspecialchars($_POST['book_autor']);
    $book_edition = htmlspecialchars($_POST['book_edition']);
    $book_comment = htmlspecialchars($_POST['book_comment']);
    $book_aditionalinfo = htmlspecialchars($_POST['kurzbeschrieb']);
    $statement = $conn->prepare('UPDATE lib_books SET  book_number = ?,book_title= ?, book_autor = ?, book_edition = ?, book_comment = ?, book_aditionalinfo = ? where bookID = ?');

    $statement->bind_param('ssssssi', $book_number, $book_title, $book_autor, $book_edition, $book_comment, $book_aditionalinfo, $bookID);
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

    header("Location: magazines.php" . $statusstr);
    exit;
}
if (isset($_POST['delete_restore_mag'])) {
    $magazineID = htmlspecialchars($_POST['delete_restoreID']);

    $statement = $conn->prepare("SELECT isDeleted FROM lib_magazines WHERE magazineID = ? ");
    $statement->bind_param("i", $bookID);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();

    if ($row['deleted'] == 0) {
        $statement = $conn->prepare('UPDATE lib_magazines SET isDeleted = 1 WHERE magazineID = ?');
        $statement->bind_param('i', $bookID);
        $statement->execute();
        header("location: magazine.php");
    } else {
        $statement = $conn->prepare('UPDATE lib_magazines SET isDeleted = 0 WHERE magazineID = ?');
        $statement->bind_param('i', $bookID);
        $statement->execute();
        header("location: magazine.php");
    }
    exit;
}

if (isset($_POST['EditMagazine'])) {
    $newFile = $_FILES['edit_cover'];

    var_dump($newFile);

    $statement = $conn->prepare('SELECT magazine_image FROM lib_magazines WHERE magazineID = ?');
    $statement->bind_param('i', $_POST['magazineID']);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();

    if (!is_null($row['magazine_image'])) {
        $delete_file = getcwd() . "/" . $row['magazine_image'];
        unlink(realpath($delete_file));
    }

    $magazine_db_filename = "../../assets/images/img/cover_mag_" . $_POST['magazineID'] . "_" . time() . ".png";

    $statement = $conn->prepare('UPDATE lib_magazines SET magazine_image = ? WHERE magazineID = ?');
    $statement->bind_param('si', $magazine_db_filename, $_POST['magazineID']);
    $statement->execute();

    $magazine_newfilename = getcwd() . "/../../assets/images/img/cover_mag_" . $_POST['magazineID'] . "_" . time() . ".png";

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