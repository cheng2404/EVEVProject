<?php
session_start();
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$isValid = false;

$DBusername = "root";
$DBpassword = "pass1234";
$DBName1 = "evev";

include('connectMySQL.php');
$db = new MySQLDatabase();
$db->connect($DBusername, $DBpassword, $DBName1);

$query = "SELECT username, password FROM user";
$result = mysqli_query($db->link, $query);
if($result) {
  while($row = mysqli_fetch_array($result)) {
    $tempUserName = $row['username'];
    $tempPassword = $row['password'];

    if ($username == $tempUserName) {
    	// pass1234 is the password for the people who has authority
    	if ($password=="pass1234" || password_verify($password, $tempPassword)) {
    		$isValid = true;
    	}
    }
  }
} else {
	die (mysqli_error($db->link));
}

if ($isValid) {
	$_SESSION['uname']=$username;
    $password = password_hash($password, PASSWORD_DEFAULT);
	$_SESSION['pws']=$password;
    $_SESSION['state']="true";
	header("Location: index.php");
    exit;
}else {
    $_SESSION['state']="false";
	header("Location: logInForm.php");
} 
?>
