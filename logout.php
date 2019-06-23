<?php

// session start
session_start();
// delete all session variables
$_SESSION = array();
// delete sesion cookie
if (isset($_COOKIE["uname"])) {
  setcookie("nname", '', time() - 1800, '/');
}
if (isset($_COOKIE["pws"])) {
	setcookie("pws", '', time() - 1800, '/');
}
session_destroy();
header("Location: index.php");
?>