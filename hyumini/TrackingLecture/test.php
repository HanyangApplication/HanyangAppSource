<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lak
 * Date: 2016. 6. 2.
 * Time: 오전 10:29
 */

header('Content-Type: application/javascript;charset=UTF-8');

$user = 'hyumini';
$pw = 'hyu(e)mini';
$db = 'hyumini';
$host = '166.104.242.130';
$port = 3306;
$table = 'LectureSchedule';

$my_db = new mysqli($host,$user,$pw,$db,$port);

mysqli_query($my_db,"set names utf8");
if ( mysqli_connect_errno() ) {
        echo mysqli_connect_errno();
        exit;
}
$callback = $_REQUEST['callback'];
$return_array = array();
$count = 0;

$rs = mysqli_query($my_db, "select * from $table limit 10");
while($data = mysqli_fetch_array($rs)){
 //  echo "<tr><td><b>강의실정보</b></td><td>".$data['classroom']."</td></tr>";
 $array[] = $data;

}


$my_db->close();
//$arr = array("message" => "You got an AJAX response via JSONP from another site! ", "time" =>$dtime, "gate_name" => $ref1);
$json_val = json_encode($array);


echo $callback."(".$json_val.")";
?>