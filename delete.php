<?php
	session_start();
	$username = $_SESSION['uname'];
	$eventID = $_GET['eventID'];

	$DBusername = "root";
	$DBpassword = "pass1234";
	$DBName = "evev";

	include('connectMySQL.php');
	$db = new MySQLDatabase();
	$db->connect($DBusername, $DBpassword, $DBName);

	$queryToSearch = "select id, username from user";
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

	$queryToDeleteJoin = "DELETE FROM joinEventUser WHERE joinEventID='$eventID' AND joinUserID='$userID'";
	$DeleteJoinResult = mysqli_query($db->link, $queryToDeleteJoin);

	$queryToDeleteHoldJoin = "DELETE joinEventUser FROM joinEventUser, event WHERE joinEventID='$eventID' AND holderID='$userID'";
	$DeleteHoldJoinResult = mysqli_query($db->link, $queryToDeleteHoldJoin);

	$queryToDeleteEvent = "DELETE FROM event WHERE eventID='$eventID' AND holderID='$userID'";
	$DeleteEventResult = mysqli_query($db->link, $queryToDeleteEvent);

	if(!$DeleteEventResult || !$DeleteHoldJoinResult || !$DeleteEventResult) {
	die (mysqli_error($db->link)); // useful for debugging
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

    <h3 style="color: white; text-align: center; padding-top: 100px;">You have been deleted the event successfully!</h3>
    <h3 style="color: white; text-align: center; padding-top: 20px;">Thank you for using EVEV!</h3>

  <div>

    <script language="javascript" type="text/javascript">
      window.setTimeout('window.location="mypage.php"; ',2000);
    </script>


    <?php $db->disconnect();?>

</body>

</html>
