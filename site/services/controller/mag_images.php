<?php


$request = preg_replace("/[^0-9]/", "", $_REQUEST['request']);

$PathArray = [];
$NamesArray = [];
$IDArray = [];

include "../../../site/services/db_connect.php";
foreach ($request as $r) {


    $statement = $conn->prepare("SELECT nickname,employeeID FROM AeBo_employees WHERE employeeID = ?");
    $statement->bind_param('i', $r);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    $imagePath = '../../assets/images/employees_200px/' . $row['nickname'] . '.png';

    array_push($PathArray, $imagePath);
    array_push($IDArray, $row['employeeID']);
    array_push($NamesArray, $row['nickname']);
}

echo json_encode(array('IDs' => $IDArray, 'paths' => $PathArray, 'names' => $NamesArray));
