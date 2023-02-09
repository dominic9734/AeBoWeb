
<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    include "../../services/db_connect.php";
    $request_scope = $_POST['request_scope'];
    $employees = [];
    $rooms = [];
    if ($request_scope == "location_zone") {
        $request = $_POST['request'];
        $statement = $conn->prepare('SELECT *
                                        FROM (SELECT location,zone,room_name
                                            FROM AeBo_rooms
                                            UNION
                                        SELECT location,zone,nickname
                                            FROM AeBo_employees
                                            ) AS U
                                        WHERE U.room_name = ?');
        $statement->bind_param("s", $request);
        $statement->execute();
        $result = $statement->get_result();

        while ($row = $result->fetch_assoc()) {
            header('Content-Type: application/json');
            echo json_encode(array('location' => $row['location'], 'zone' => $row['zone'], 'room_name' => $row['room_name']));
        }
    } elseif ($request_scope == "query") {
        $location = $_POST['location'];
        $zone = $_POST['zone'];
        $statement = $conn->prepare("SELECT * FROM AeBo_employees WHERE location = ? AND zone = ?");
        $statement->bind_param("ss", $location, $zone);
        $statement->execute();
        $result = $statement->get_result();
        while ($row = $result->fetch_assoc()) {

            $employees[] = [
                'ID' => $row['employeeID'], 'first_name' => $row['first_name'], 'last_name' => $row['last_name'], 'nickname' => $row['nickname'], 'location' => $row['location'], 'zone' => $row['zone'], 'work_division' => $row['work_division'], 'internal_phone' => $row['internal_phone'], 'mobile_phone' => $row['mobile_phone'], 'primary_mail' => $row['primary_mail'], 'special_authority' => $row['special_authority'], 'department' => $row['department']
            ];
        }
        $statement = $conn->prepare("SELECT * FROM AeBo_rooms WHERE location = ? AND zone = ?");
        $statement->bind_param("ss", $location, $zone);
        $statement->execute();
        $result = $statement->get_result();
        while ($row = $result->fetch_assoc()) {

            $rooms[] = [
                'ID' => $row['roomID'], 'room_name' => $row['room_name'], 'location' => $row['location'], 'zone' => $row['zone'], 'work_division' => $row['work_division']
            ];
        }

        header('Content-Type: application/json');
        $result = array('employees' => $employees, 'rooms' => $rooms);
        echo json_encode($result);
    } elseif ($request_scope == "departmentquery") {
        $location = $_POST['location'];
        $zone = $_POST['zone'];
        $work_division = $_POST['work_division'];
        $statement = $conn->prepare("SELECT * FROM AeBo_employees WHERE location = ? AND zone = ? AND work_division = ?");
        $statement->bind_param("sss", $location, $zone, $work_division);
        $statement->execute();
        $result = $statement->get_result();
        while ($row = $result->fetch_assoc()) {

            $members[] = [
                'ID' => $row['employeeID'], 'first_name' => $row['first_name'], 'last_name' => $row['last_name'], 'nickname' => $row['nickname'], 'location' => $row['location'], 'zone' => $row['zone'], 'work_division' => $row['work_division'], 'internal_phone' => $row['internal_phone'], 'mobile_phone' => $row['mobile_phone'], 'primary_mail' => $row['primary_mail'], 'special_authority' => $row['special_authority'], 'department' => $row['department']
            ];
        }
        header('Content-Type: application/json');
        $result = array('members' => $members);
        echo json_encode($result);
    } else {
        exit;
    }
    exit;
}
