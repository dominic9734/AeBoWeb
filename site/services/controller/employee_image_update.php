
<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    include "../../services/db_connect.php";
    $path = $_POST['path'];
    $employeeID = $_POST['employeeID'];

    $newimagename = "employeeimage_" . $_POST['employeeID'] . "_" . time() . ".png";

    $statement = $conn->prepare("UPDATE AeBo_employees SET employee_image = ? WHERE employeeID = ?");
    $statement->bind_param("si", $newimagename, $employeeID);
    //$statement->execute();
    $statement->close();


    if (!is_null($row['path'])) {
        $delete_file = getcwd() . "/" . $row['path'];
        //unlink(realpath($delete_file));
    }

    $new_filename = "../../assets/images/employees_200px/employeeimage_" . $_POST['magazineID'] . "_" . time() . ".png";

    echo $new_filename;

    //move_uploaded_file($newFile['tmp_name'], $magazine_newfilename);

    header('Content-Type: application/json');




    //header('Content-Type: application/json');
    //echo json_encode(array('status' => "success"));

    exit;
}

?>
