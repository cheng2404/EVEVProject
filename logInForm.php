<?php 
  session_start();
  $loginState = $_SESSION['state'];
  if(isset($_SESSION['uname']) && isset($_SESSION['pws'])) {
    header("Location: index.php");
  } else if ($loginState=="false") {
    echo "<div id='loginFail' class='alert alert-danger' role='alert'>
          Username or password is incorrect!!
          </div>";
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <style>

    input[type=text], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }


    button {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    button:hover {
        opacity: 0.8;
    }

    .cancelbtn {
        width: auto;
        padding: 10px 18px;
        background-color: #f44336;
    }


    .container {
        padding: 16px;
    }


    .modal-content {
        background-color: #fefefe;
        margin: 5% auto 20% auto;
        border: 1px solid #888;
        width: 80%;
    }


    .close {
        position: absolute;
        right: 25px;
        top: 0;
        color: #000;
        font-size: 35px;
        font-weight: bold;
    }

    .close:focus {
    color: red;
    cursor: pointer;
  }
    </style>


    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta name="keywords" content="weather,world,Openstreetmap,forecast, Openweather,current">
    <meta name="description" content="">
    <meta http-equiv="pragma" content="no=cache">
    <meta http-equiv="Expires" content="=1">

  </head>
  <body>

    <div class="header">
      <img src="img/upLog.png" alt="EVEV title" style="width: 100%; height: 100px;" >
      <a href="index.php"><button class="btn" style="background:none; width: 320px; height:80px; border: 0; margin-top: -80px;"></button></a>
    </div>

  <div >
    <div class="loginintitle" width="100%" style="text-align:center">
      <h1>Welcome To Log In</h1>
      </div>
  </div>

<div>
  <hr style="border-width: 5px;" color="#990000;">

    <form class="modal-content animate" method="post" action="login.php">
      <div class="container">
        <label for="uname"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="username" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" minlength="8" placeholder="Enter Password" name="password" required>
        
        <div class="row" style="margin-bottom:20px;">
        <div class="col-4"></div>
        <div class="col-4"><button type="submit">Login</button></div>
        <div class="col-4"></div>
      </div>
    
    <div class="row" style="margin:40px 10px 30px 10px;">
      <div class="col-3">
        <a href="index.php"><button type="button" class="btn btn-danger">Cancel</button></a>
      </div>
      <div class="col-6"></div>
      <div class="col-3">
        <a href="signup.html"><button type="button" class="btn btn-info">Sign up</button></a>
      </div>
    </div>
      
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="facebook.js"></script>

</div>

  </body>
</html>
