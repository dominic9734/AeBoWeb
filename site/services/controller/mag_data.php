
<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    include "../../services/db_connect.php";
    $magazineID = $_POST['magazineID'];

    $statement = $conn->prepare(
        "SELECT AeBo_employees.nickname,junction_magazines.employeeID 
    FROM junction_magazines 
    LEFT JOIN AeBo_employees 
    ON junction_magazines.employeeID = AeBo_employees.employeeID 
    WHERE junction_magazines.magazineID = ?; "
    );
    $statement->bind_param("s", $magazineID);
    $statement->execute();
    $result = $statement->get_result();
    while ($row = $result->fetch_assoc()) {

        $employees[] = [
            'employeeID' => $row['employeeID'], 'nickname' => $row['nickname'], 'path' => '../../assets/images/employees_200px/' . $row['nickname'] . '.png'
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($employees);
    exit;
}