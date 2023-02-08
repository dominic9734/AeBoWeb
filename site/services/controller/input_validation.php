<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $employeeID = $_POST['employeeID'];
    $magazineID = $_POST['magazineID'];
    include "../../services/db_connect.php";

    $statement = $conn->prepare("SELECT junctionID
    FROM junction_magazines
    LEFT JOIN AeBo_employees
    ON junction_magazines.employeeID = AeBo_employees.employeeID 
    WHERE junction_magazines.employeeID = ? AND junction_magazines.magazineID = ?");
    $statement->bind_param("ss", $employeeID, $magazineID);
    $statement->execute();
    $result = $statement->get_result();
    if ($result->num_rows == 0) {

        $statement = $conn->prepare("SELECT nickname, first_name, last_name FROM AeBo_employees WHERE employeeID = ?");
        $statement->bind_param("s", $employeeID);
        $statement->execute();
        $result = $statement->get_result();
        while ($row = $result->fetch_assoc()) {
            header('Content-Type: application/json');
            echo json_encode(array('response' => "valid", 'employeeID' => $employeeID, 'nickname' => $row['nickname'], 'full_name' => $row['first_name'] . ' ' . $row['last_name'], 'path' => '../../assets/images/employees_200px/' . $row['nickname'] . '.png'));
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(array('response' => "invalid"));
    }
    exit;
}
