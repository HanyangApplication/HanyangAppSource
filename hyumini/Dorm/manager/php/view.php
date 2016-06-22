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
    case "accept":
    	$response['status'] = 400;
    	if ($_POST['data'] == "") {
    		$response['message'] = 'Please give data.';
    	}else {
    		$data_arr = $_POST['data'];

    		$response['error_data'] = array();

			$flag = 0;//record if all data is update success

    		//each array, check room, then update or return error
    		foreach ($data_arr as $key => $value) {
				$value = intval($value);

				//by students table to check if this room enabled.
    			$sql = "SELECT count(*) AS count FROM `students` t WHERE `room`=(
    			SELECT t.`room` FROM `students` t WHERE t.id=$value
    			) AND `status`=1 AND `id` <> $value;";

    			/*if use room table:
    			$sql = "SELECT t.num AS count FROM `room` t WHERE `room`=(
    			SELECT t.`room` FROM `students` t WHERE t.id=$value
    			);";
    			*/

	            $result = $mysqli->query($sql);  

	            $count = intval($result->fetch_all(MYSQLI_ASSOC)[0]['count']);

	            //if room enabled update else push wrong stdID to array
    			if ($count < 2) {
    				$sql = "UPDATE `students` SET status=1 WHERE id=$value";

    				$result = $mysqli->query($sql);
    			}else {
    				array_push($response['error_data'], $value);
    				$flag++;

    				$sql = "UPDATE `students` SET status=3 WHERE id=$value";

    				$result = $mysqli->query($sql);
    			}
    		}

    		if ($flag) {
    			$response['status'] = 205;
	    		$response['message'] = $flag . ' data(s) can not update.';
    		}else{
    			$response['status'] = 200;
	    		$response['message'] = 'All data update success.';
    		}
    	}
    	break;  
    case "reject":
    	$response['status'] = 400;
    	if ($_POST['data'] == "") {
    		$response['message'] = 'Please give data.';
    	}else {
    		$data_arr = $_POST['data'];

    		$data_arr_string = join(',', $data_arr);//convert array to string

    		$sql = "UPDATE `students` SET `status`=2 WHERE `id` in ($data_arr_string);";
    		
    		$result = $mysqli->query($sql);

    		$response['status'] = 200;
    		$response['message'] = 'success';
    	}

        break;
    default:
        $response['status'] = 400;
        $response['message'] = "Please give an action.";
}

$mysqli->close();
echo json_encode($response);