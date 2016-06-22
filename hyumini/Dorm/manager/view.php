<?php 
require_once 'php/Mysqli.php';

static $status_arr = [
'Non-checked',
'Assigned',
'Rejected',
'Discordant'
];

$page_start = 1;
$page_row = 10;
$name = "";
$stdid = "";

if (isset($_POST['page'])&&($_POST['page'] != "")) {
  $page_start = intval($_POST['page']);
  $page_start = ($page_start<1)?1:$page_start;
}
if (isset($_POST['row'])&&($_POST['row'] != "")) {
  $page_row = intval($_POST['row']);
}
if (isset($_POST['name'])&&($_POST['name'] != "")) {
  $name = mysqli_real_escape_string($mysqli, $_POST['name']);
}
if (isset($_POST['stdid'])&&($_POST['stdid'] != "")) {
  $stdid = mysqli_real_escape_string($mysqli, $_POST['stdid']);
}

$sql = "SELECT id AS id, name AS name, status AS status, a_building AS a_building, a_room AS a_room FROM (";
$sql = $sql . " SELECT * FROM students WHERE `payment` = 1 ";
if ($name != "") {
  $sql = $sql . " AND `name` LIKE '%$name%' ";
}
if ($stdid != "") {
  $sql = $sql . " AND `id` LIKE '%$stdid%' ";
}
$sql = $sql . " ) students ORDER BY `id` ASC LIMIT " . (($page_start - 1) * $page_row ) . "," . $page_row . ";";

$result = $mysqli->query($sql);

$data = $result->fetch_all(MYSQLI_ASSOC);
$mysqli->close();
?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8"> 
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body>
  <div id="panel">
    <div><h3 id="title">Dormitory Management</h3></div>
      <div>
        <form class="search-page-form" action="./view.php" method="POST">
          <input type="hidden" name="page" value="<?php echo $page_start; ?>" />
          <label for="name">Name:</label>
          <input id="name" name="name" value="<?php 
          if ($name != "") {
            echo $name;
          } 
          ?>" type="text"></input>
          <label for="stdid">Student ID:</label>
          <input id="stdid" name="stdid" value="<?php 
          if ($stdid != "") {
            echo $stdid;
          } 
          ?>" type="text"></input>
          
          <button class="btn btn-success btn-sm" id='search' type="submit" >Search</button>
        </form>
        <table class="table table-striped table-condensed table-bordered">
          <thead>
            <tr>
              <th>Selected</th>
              <th>Name</th>
              <th>Student ID</th>
              <th>Building</th>
              <th>Room</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($data as $key => $value) { ?>
            <tr>
              <td width=10%>
                <label>
                  <input type="checkbox" data-id="<?php echo $value['id']; ?>" />
                </label>
              </td>
              <td><?php echo $value['name']; ?></td>
              <td><?php echo $value['id']; ?></td>
              <td><?php echo $value['a_building']; ?></td>
              <td><?php echo $value['a_room']; ?></td>
              <td><?php echo $status_arr[intval($value['status'])]; ?></td>
              <td>
                <?php if (intval($value['status']) != 1) {
                  echo '<button class="btn btn-success btn-sm btn-accept">Accept</button>';
                }else {
                  echo '<button class="btn btn-danger btn-sm btn-reject">Reject</button>';
                }?>
                <button class="btn btn-primary btn-sm btn-edit">Edit</button>
              </td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        <div class="page-control">
        <?php if ($page_start>1) {?>
          <a data-type="p" target="_self"><span><span class="glyphicon glyphicon-triangle-left"></span>Previous Page</span></a>
        <?php }?>
        <?php if (count($data)>=$page_row) {?>
          <a data-type="n" target="_self"><span>Next Page<span class="glyphicon glyphicon-triangle-right"></span></span></a>
        </div>
        <?php }?>
      </div>
      <div class="btn-form-function">
        <button class="btn btn-danger btn-sm reject-all">Reject</button>
        <button class="btn btn-success btn-sm accept-all">Accept</button>
        <a class="btn btn-default btn-sm" href="main.html" target="_self">Back</a>
      </div>
  </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="js/view.js"></script>
</body>
</html>