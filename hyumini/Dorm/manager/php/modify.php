<?php

require_once 'Mysqli.php';

$response = [
    'status'=>500,
    'message'=>'mission failed.'
];

if ((isset($_POST['action'])) && ($_POST['action'] != '')) {
    $action = $_POST['action'];
}

switch ($action)
{
    case "getinfo":
        $response['status'] = 400;

        $name = $_POST['in_name'];
        $id = $_POST['in_id'];

        if ($name == "" && $id == "") {
            $response['message'] = "Least give one param.";
        } else {
            if ($id != "") {
                $sql = 'SELECT `id`, `name`, `a_building`, `a_room` FROM `students` WHERE `id` LIKE ? LIMIT 20;';

                $stmt = $mysqli->prepare($sql) or die($mysqli->error);  

                $id = "%".$id."%";
                $stmt->bind_param("s", $id);
            }else {
                $sql = 'SELECT `id`, `name`, `a_building`, `a_room` FROM `students` WHERE `name` LIKE ? LIMIT 20;';

                $stmt = $mysqli->prepare($sql) or die($mysqli->error);  

                $name = "%".$name."%";
                $stmt->bind_param("s", $name);
            }
            
            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($id,$name,$building,$room);

            $response['status'] = 200;
            $response['message'] = 'success';
            $response['data'] = [];

            while ($stmt->fetch()) {
                array_push($response['data'], ['id'=>$id,'name'=>$name,'building'=>$building,'room'=>$room]);
            }
        }

        break;  
    case "updateinfo":
        $response['status'] = 400;

        $name = $_POST['name'];
        $id = $_POST['id'];
        $building = $_POST['dorm'];
        $room = $_POST['room'];

        //$sql = 'REPLACE INTO `students`(`id`, `name`, `a_building`, `a_room`, `payment`) VALUES (?, ?, ?, ?, 0);';
        $result = $mysqli->query("select * from `students` where `id`=$id;");
        //$x = mysqli_fetch_arry($sql);

        if($result->num_rows == 0)
        {
            //echo "1";
            $sql = "insert into `students` (`name`,`id`,`a_building`,`a_room`) VALUES(?,?,?,?);";
            $stmt = $mysqli->prepare($sql) or die($mysqli->error);
            $stmt ->bind_param("siss",$name,$id,$building,$room);
        }
        else
        {
        
           // echo "b";

            $sql = 'update `students` set `a_building`=?, `a_room`=? where `id`=?;';
            //echo "there is this student. it will be updated.";
            $stmt = $mysqli->prepare($sql) or die($mysqli->error);  
            
            //$stmt->bind_param("isss", $id, $name, $building, $room);
            $stmt->bind_param("ssi",$building,$room,$id);
            
        }
        
        $stmt->execute();
        $stmt->store_result();

        $response['status'] = 200;
        $response['message'] = 'success';
        $response['data'] = [];

        while ($stmt->fetch()) {
            array_push($response['data'], ['id'=>$id,'name'=>$name,'building'=>$building,'room'=>$room]);
        }

        break;
    case "checkroom":
        $response['status'] = 400;

        $room = $_POST['room'];
        $id = $_POST['id'];

        if ($room == "" || $id == "") {
            $response['message'] = "no param.";
        } else {
            $sql = 'SELECT `id`, `name`, `a_building`, `a_room` FROM `students` WHERE `a_room`=? AND `id` <> ?;';

            $stmt = $mysqli->prepare($sql) or die($mysqli->error);  

            $room = $room;
            $stmt->bind_param("si", $room, $id);
            
            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($id,$name,$building,$room);

            $response['status'] = 200;
            $response['message'] = 'success';
            $response['data'] = [];

            while ($stmt->fetch()) {
                array_push($response['data'], ['id'=>$id,'name'=>$name,'building'=>$building,'room'=>$room]);
            }
        }

        break;
    default:
        $response['status'] = 400;
        $response['message'] = "Please give an action.";
}

$mysqli->close();
echo json_encode($response);