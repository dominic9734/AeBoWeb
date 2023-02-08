
<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    include "../../services/db_connect.php";
    $RemovedEmployees = $_POST['RemovedEmployees'];
    $AddedEmployees = $_POST['AddedEmployees'];
    $magazineID = $_POST['magazineID'];
    

    foreach ($AddedEmployees as $NS) {

        $statement = $conn->prepare("INSERT INTO junction_magazines (employeeID,magazineID) VALUES(?,?)");
        $statement->bind_param("ss", $NS, $magazineID);
        $statement->execute();
        $statement->close();
    }


    foreach ($RemovedEmployees as $RS) {

        $statement = $conn->prepare("DELETE FROM junction_magazines WHERE employeeID = ? AND magazineID = ?");
        $statement->bind_param("ss", $RS, $magazineID);
        $statement->execute();
        $statement->close();
    }


    exit;
}
