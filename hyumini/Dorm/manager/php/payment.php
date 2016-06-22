<?php

require_once 'Mysqli.php';

$response = [
    'status'=>500,
    'message'=>'mission failed.'
];

if ((isset($_POST['action'])) && ($_POST['action'] != '')) {
    $action = $_POST['action'];
}
if ((isset($_GET['action'])) && ($_GET['action'] != '')) {
    $action = $_GET['action'];
}

switch ($action)
{
    case "list":
        $response['status'] = 400;
        $page = mysqli_real_escape_string($mysqli, $_GET['page']);
        $col = mysqli_real_escape_string($mysqli, $_GET['col']);

        if ($page == "" || $col == "") {
            $response['message'] = "no param.";
        }else {
            $page = intval($page);
            $response['page'] = $page;
            $col = intval($col);
            $result = $mysqli->query("SELECT COUNT(*) AS `count` FROM `students`;");

            $count = $result->fetch_all(MYSQLI_ASSOC)[0]['count'];
            $count = intval($count);
            $pages = ceil($count / $col);

            $result->close();

            $page = ($page - 1) * $col;
            $sql = 'SELECT `id`, `name`, `a_building`, `a_room`, `payment` FROM `students` WHERE 1 LIMIT ? , ?';

            $stmt = $mysqli->prepare($sql) or die($mysqli->error);  

            $stmt->bind_param("ii", $page, $col);

            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id,$name,$building,$room,$payment);

            $response['status'] = 200;
            $response['message'] = 'success';
            $response['count'] = $count;
            $response['pages_tot'] = $pages;
            $response['data'] = [];

            while ($stmt->fetch()) {
                array_push($response['data'], ['id'=>$id,'name'=>$name,'building'=>$building,'room'=>$room,'payment'=>$payment]);
            }

        }
        break;
    case "update":
        $response['status'] = 400;
        $id = $_POST['id'];
        $payment = $_POST['value'];

        if ($id == "" || $payment == "") {
            $response['message'] = "no param.";
        } else {
            $id = intval($id);
            $payment = intval($payment);
            
            $sql = 'UPDATE `students` SET `payment` = ? WHERE `id` = ?;';

            $stmt = $mysqli->prepare($sql) or die($mysqli->error);  

            $stmt->bind_param("ii", $payment, $id);
            
            $result = $stmt->execute();

            if ($result) {
                $response['status'] = 200;
                $response['message'] = 'success';
            }else {
                $response['message'] = 'Database error.';
            }
        }

        break;
    default:
        $response['status'] = 400;
        $response['message'] = "Please give an action.";
}

$mysqli->close();
echo json_encode($response);