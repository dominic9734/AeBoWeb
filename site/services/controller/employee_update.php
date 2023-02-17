
<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    include "../../services/db_connect.php";
    $updatedata = $_POST['updatedata'];
    $updateID = $_POST['updateID'];


    $first_last_name = preg_split('/\s+/', $updatedata[1]);

    
    // Remove any HTML tags from the updatedata array
    foreach ($updatedata as $key => $value) {
        $updatedata[$key] = strip_tags($value);
    }


    
    $stmt = $conn->prepare('UPDATE AeBo_employees SET first_name = ?, last_name = ?, nickname = ?, location = ?, zone = ?, work_division = ?, internal_phone = ?, mobile_phone = ? , primary_mail = ?,special_authority = ?,department = ? WHERE employeeID = ?');
    $stmt->bind_param('ssssssssssss', $first_last_name[0], $first_last_name[1], $updatedata[2], $updatedata[9], $updatedata[10], $updatedata[3], $updatedata[4], $updatedata[5], $updatedata[6], $updatedata[7],$updatedata[8], $updateID);
    $stmt->execute();
    

    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode(array('status' => "success"));
    } else {
        header('Content-Type: application/json');
        echo json_encode(array('status' => "fail"));
    }
    exit;
}
