<?php
session_start();
//Get Event ID by joinBtnName
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$joinBtnName = key($_POST);
$eventID = substr($joinBtnName, 8);

$username = $_SESSION['uname'];
$joinID = mt_rand(10000000, 99999999);

$DBusername = "root";
$DBpassword = "pass1234";
$DBName = "evev";

include('connectMySQL.php');
$db = new MySQLDatabase();
$db->connect($DBusername, $DBpassword, $DBName);

$queryToSearch = "SELECT id, username FROM user";
$searchResult = mysqli_query($db->link, $queryToSearch);

if($searchResult) {
  while($row = mysqli_fetch_array($searchResult)) {
    $rowUsername = $row['username'];
    if ($username==$rowUsername) {
      $userID = $row['id'];
    } else {error_log("userID has problem");}
  }
} else {
  die(mysqli_error($db->link)); // useful for debugging
} 

//Convert to integer for each ID
$eventID = (int)$eventID;
$userID = (int)$userID;
$queryToCreate = "INSERT INTO joinEventUser(joinID, joinEventID, joinUserID) VALUES ('$joinID', '$eventID', '$userID')";
$createResult = mysqli_query($db->link, $queryToCreate);

if(!$createResult) {
die (mysqli_error($db->link));
} 

?>

<!DOCTYPE html>
<html>
<head>
  <title>EVEV</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
  <div class="header">
    <img src="img/upLog.png" alt="EVEV title" width="100%" height="100%">
  </div>

  <div style="width:800px; height:400px; background-color: green; margin-left:auto; margin-top: 5%; margin-right: auto;">

    <h3 style="color: white; text-align: center; padding-top: 100px;">You have been joined in this event successfully!</h3>
    <h3 style="color: white; text-align: center; padding-top: 20px;">Thank you for using EVEV!</h3>

  <div>

    <script language="javascript" type="text/javascript">
      window.setTimeout('window.location="index.php"; ',2000);
    </script>

    <?php $db->disconnect();?>

</body>

</html>
