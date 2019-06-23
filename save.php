<?php
session_start();
/*Image Upload */
$target_dir = "upload/";
$target_file = $target_dir . basename($_FILES["image1"]["name"]);
$uploadSuccess = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//Check if image file is a actual image of fake image
if(isset($_POST["submit"])) {
	$check = getimagesize($_FILES["image1"]["tmp_name"]);
	if($check != false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadSuccess = 1;
	}  else {
		echo "Fils is not an image.";
		$uploadSuccess = 0;
	}
}

//Check file size
if ($_FILES["image1"]["size"]>20000000) {
	echo "Sorry, your file is too large.";
	$uploadSuccess = 0;
}
//Allow certain file formats
if($imageFileType!="jpg" && $imageFileType!="png" && $imageFileType!="jpeg" && $imageFileType!="gif") {
	echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
	$uploadSuccess = 0;
}
//Check $uploadSuccess
if($uploadSuccess==0) {
	echo "Sorry, your file was not uploaded.";
} else {
	if (move_uploaded_file($_FILES["image1"]["tmp_name"], $target_file)) {
		echo "This file " . basename($_FILES["image1"]["name"]) . " has been uploaded.";
	} else {
		echo "Sorry, there was an error uploading your file.";
	}
} 

$eventImg1 = $target_file;

$eventTitle = $_POST['title'];
$eventHour = $_POST['hour'];
$eventMinute = $_POST['minute'];
$eventDate = $_POST['date'];
$eventMonth = $_POST['month'];
$eventYear = $_POST['year'];
$eventCat = $_POST['category'];
$eventOrg = $_POST['organisation'];
$eventLoc = $_POST['location'];
$eventDes = $_POST['descp'];

$dateTimeFormat = 'Y-m-d H:i:s';
$DateTime = $eventYear . "-" . $eventMonth . "-" . $eventDate . " " . $eventHour . ":" . $eventMinute. ":00";
$eventDateTimeStamp = strtotime($DateTime);
$eventDateTime = date("Y-m-d H:i:s", $eventDateTimeStamp);

$eventID = $_GET['eventID'];

$DBusername = "root";
$DBpassword = "pass1234";
$DBName = "evev";

include('connectMySQL.php');
$db = new MySQLDatabase();
$db->connect($DBusername, $DBpassword, $DBName);

$queryToUpdate= "UPDATE event
				SET name= '$eventTitle',
				category = '$eventCat',
				organisation = '$eventOrg',
				location = '$eventLoc',
				eventDateTime = '$eventDateTime',
				description = '$eventDes',
				image1 = '$eventImg1'
				WHERE eventID='$eventID'";
$updateResult = mysqli_query($db->link, $queryToUpdate); 

echo "Update successfully!";
header("Location: mypage.php");
if(!$updateResult) {
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

    <h3 style="color: white; text-align: center; padding-top: 100px;">You have been edited this event successfully!</h3>
    <h3 style="color: white; text-align: center; padding-top: 20px;">Thank you for using EVEV!</h3>

  <div>

    <script language="javascript" type="text/javascript">
      window.setTimeout('window.location="mypage.php"; ',2000);
    </script>

    <?php $db->disconnect();?>

</body>

</html>
