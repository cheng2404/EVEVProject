<?php 
  session_start();
  if(isset($_SESSION['uname'])!= "") {
    header("Location: /INFS/main.php");
  }

  $username = "root";
  $password = "pass1234";
  $dbName1 = "evev";

  include('connectMySQL.php');
  $db = new MySQLDatabase();
  $db->connect($username, $password, $dbName1);

  $id = mt_rand(10000000, 99999999);
  $username = $_POST['username'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email']; 
  $password = $_POST['password']; 
  $password = password_hash($password, PASSWORD_DEFAULT);
  $query = "INSERT INTO user(id, firstname, lastname, username, email, password) VALUES ('$id', '$firstname', '$lastname', '$username', '$email', '$password')";
  $result = mysqli_query($db->link, $query);

  echo "success";
  $_SESSION['uname'] = $username;
  $_SESSION['pws'] = $password;
  header("Location: index.php");
  if(!$result) {
    die (mysqli_error($db->link));
  } 

  $db-disconnect();
?>