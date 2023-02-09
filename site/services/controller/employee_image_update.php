
<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    include "../../services/db_connect.php";
    $path = $_POST['path'];
    $employeeID = $_POST['employeeID'];

    $newimagename = "employeeimage_" . $_POST['employeeID'] . "_" . time() . ".png";

    $statement = $conn->prepare("UPDATE AeBo_employees SET employee_image = ? WHERE employeeID = ?");
    $statement->bind_param("si", $newimagename, $employeeID);
    $statement->execute();
    $statement->close();

    header('Content-Type: application/json');




    //header('Content-Type: application/json');
    //echo json_encode(array('status' => "success"));

    exit;
}

?>
