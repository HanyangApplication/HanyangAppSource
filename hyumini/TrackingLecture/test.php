<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lak
 * Date: 2016. 6. 2.
 * Time: 오전 10:29
<<<<<<< HEAD
 *	Author: Hyunglak Kim
 *
 *	@Description
 *	현재 Session 정보 중에 SID(학번을 가져와서) DB의 2개의 테이블 Join을 통해서
 *  사용자의 강의실 정보를 가져온다
 *
 *
 *	$_GET["SID_key"];
 *	SID_key: 학번
 *
 *	Return 결과
 *  JSON Data
 *	                     HTTP Response Code
 *	Error			:	-1		400/500
 *	Fail			:	 0		404
 *	Success			:	 1		200
 *	First Login		:	 2		200
 *	Admin			:	 3		200
 *	Admin & First	:	 4		200
 *
=======
>>>>>>> 2873a68b686eb6814f890248c428eb3ba3bb38c1
 */

header('Content-Type: application/javascript;charset=UTF-8');

$user = 'hyumini';
$pw = 'hyu(e)mini';
$db = 'hyumini';
<<<<<<< HEAD
$host ='localhost';
=======
$host = '166.104.242.130';
>>>>>>> 2873a68b686eb6814f890248c428eb3ba3bb38c1
$port = 3306;
$table = 'LectureSchedule';

$my_db = new mysqli($host,$user,$pw,$db,$port);

mysqli_query($my_db,"set names utf8");
if ( mysqli_connect_errno() ) {
        echo mysqli_connect_errno();
        exit;
}
<<<<<<< HEAD
$q=$_GET["SID_key"];

=======
>>>>>>> 2873a68b686eb6814f890248c428eb3ba3bb38c1
$callback = $_REQUEST['callback'];
$return_array = array();
$count = 0;

<<<<<<< HEAD
$rs = mysqli_query($my_db, "select DISTINCT  LectureSchedule.classroom
from ConnectLecture JOIN LectureSchedule 
ON ConnectLecture.SID = $q AND ConnectLecture.lectureID = LectureSchedule.lectureID");


while($data = mysqli_fetch_array($rs))
{
 $array[] = $data;
=======
$rs = mysqli_query($my_db, "select * from $table limit 10");
while($data = mysqli_fetch_array($rs)){
 //  echo "<tr><td><b>강의실정보</b></td><td>".$data['classroom']."</td></tr>";
 $array[] = $data;

>>>>>>> 2873a68b686eb6814f890248c428eb3ba3bb38c1
}


$my_db->close();
<<<<<<< HEAD

=======
//$arr = array("message" => "You got an AJAX response via JSONP from another site! ", "time" =>$dtime, "gate_name" => $ref1);
>>>>>>> 2873a68b686eb6814f890248c428eb3ba3bb38c1
$json_val = json_encode($array);


echo $callback."(".$json_val.")";
?>