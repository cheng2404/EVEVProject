<?php
session_start();
ini_set("display_errors", 1);
error_reporting(E_ALL);

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

$username = $_SESSION['uname'];
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

$eventID = mt_rand(10000000, 99999999);
$dateTimeFormat = 'Y-m-d H:i:s';
$DateTime = $eventYear . "-" . $eventMonth . "-" . $eventDate . " " . $eventHour . ":" . $eventMinute. ":00";
$eventDateTimeStamp = strtotime($DateTime);
$eventDateTime = date("Y-m-d H:i:s", $eventDateTimeStamp);

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
    } else {error_log(" userIDhas problem");}
  }
} else {
  die(mysqli_error($db->link)); // useful for debugging
} 

$queryToCreate = "INSERT INTO event(eventID, holderID, name, category, organisation, location, eventDateTime, description, image1) VALUES ('$eventID', '$userID', '$eventTitle', '$eventCat', '$eventOrg', '$eventLoc', '$eventDateTime', '$eventDes', '$eventImg1')";
$createResult = mysqli_query($db->link, $queryToCreate);

header("Location: index.php");
if(!$createResult) {
die (mysqli_error($db->link)); // useful for debugging
} 
$db-disconnect(); 
?>