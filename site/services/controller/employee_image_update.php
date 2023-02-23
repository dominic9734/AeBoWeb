
<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    include "../../services/db_connect.php";
    $image = $_FILES['image'];
    $time = time();

    if (!is_null($_POST['path'])) {
        $delete_file = getcwd() . "/../" . $_POST['path'];
        unlink($delete_file);
    }
    move_uploaded_file($image['tmp_name'],  getcwd() . "/../../../assets/images/employees_200px/employeeimage_" . $_POST['employeeID'] . "_" . $time . ".png");
    $filename = "employeeimage_" . $_POST['employeeID'] . "_" . $time . ".png";
    $statement = $conn->prepare("UPDATE AeBo_employees SET employee_image = ? WHERE employeeID = ?");
    $statement->bind_param("si", $filename, $_POST['employeeID']);
    $statement->execute();
    header('Content-Type: application/json');
    echo json_encode(array('status' => "success"));
    exit;
}

?>
