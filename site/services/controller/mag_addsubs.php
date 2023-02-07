
<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    include "../../services/db_connect.php";
    $AddedEmployees = $_POST['AddedEmployees'];
    $updateID = $_POST['updateID'];

    var_dump($AddedEmployees);
    
    exit;
}


if (isset($_POST['MagSubs'])) {
    echo "test";
    $AddedEmployeesArray = array_map('intval', (json_decode($_POST['AddedEmployeesArray'])));
    $RemovedEmployeesArray = (json_decode($_POST['RemovedEmployeesArray']));

    var_dump($AddedEmployeesArray);

    $statement = $conn->prepare("SELECT magazine_subscribers from lib_magazines WHERE magazineID = ?");
    $statement->bind_param('i', $_POST['MagazineID']);
    echo $_POST['MagazineID'];
    $statement->execute();
    $result = $statement->get_result();
    if ($result->num_rows != 0) {
        while ($row = $result->fetch_assoc()) {
            if (!is_null($row['magazine_subscribers'])) {
                $magazine_subscribers = json_decode($row['magazine_subscribers']);
                $magazine_subscribers = array_map('intval', $magazine_subscribers);
            }
        }
    }
    if (count($AddedEmployeesArray) > 0) {
        if (!empty($magazine_subscribers)) {
            $TotalSubs = array_merge($magazine_subscribers, $AddedEmployeesArray);
            $TotalSubs = array_diff($TotalSubs, $RemovedEmployeesArray);
        } else {
            $TotalSubs = array_diff($AddedEmployeesArray, $RemovedEmployeesArray);
        }
    } else {
        $TotalSubs = array_diff($magazine_subscribers, $RemovedEmployeesArray);
    }
    $TotalSubs = "[" . implode(", ", array_unique($TotalSubs)) . "]";
    $statement = $conn->prepare("   UPDATE lib_magazines
                                    SET magazine_subscribers = ?
                                    WHERE magazineID = ?");
    $statement->bind_param('si', $TotalSubs, $_POST['MagazineID']);
    $statement->execute();
    header("Refresh:0; url=../user/magazines.php");
    exit;
}
