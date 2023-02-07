<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $validation_input = $_POST['validation_input'];
    include "../../services/db_connect.php";
    $statement = $conn->prepare("SELECT nickname,mitarbeiterID FROM AeBo_employees WHERE BINARY nickname = ?");
    $statement->bind_param("s", $validation_input);
    $statement->execute();
    $result = $statement->get_result();
    if ($result->num_rows != 0) {
        while ($row = $result->fetch_assoc()) {
            header('Content-Type: application/json');
            echo json_encode(array('response' => "valid", 'ID' => $row['mitarbeiterID']));
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(array('response' => "invalid"));
    }
    exit;
}
