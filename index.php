<?php
  session_start();
  if(!isset($_SESSION['uname']) || !isset($_SESSION['pws'])) {
    $_SESSION['loginState'] = "false";
  } else {
    $_SESSION['loginState'] = "true";
    $currentName = $_SESSION['uname'];
  }
?>

<DOCTYPE html>


<html lang="en">
<head>
  <title>EVEV</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <link rel="stylesheet" type="text/css" href="common.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="pragma" content="no=cache">
  <meta http-equiv="Expires" content="=1">
  <meta name="p!domain_varify" content="34fe229eabB562dca90f4a5962ff80a9"/>
  <style>
     #map {
      height: 500px;
      width: 97%;
     }
  </style>

</head>

<body>
  <!--Alert to tell login state -->
  <div id="loginAlert" class="alert alert-danger" role="alert" style="display:none">
  Please login or sign up!!
  </div>

  <div class="header">
    <img src="img/upLog.png" alt="EVEV title" width="100%">
    <a href="index.php"><button class="btn" style="background:none; width: 320px; height:80px; border: 0; margin-top: -80px;"></button></a>
    <button type="button" id="loginBtn" class="btn btn-secondary" onclick="window.location.href='logInForm.php'">Log In</button>

    <div class="dropdown" id="accountDrop" style="margin-top: 20px;">
      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="padding: 0 32px;">
        <p>My Account</p>
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" style="height:105px; padding:0;">
        <li>
          <button style="width:100%; height:38px; border: 0px; padding-bottom: 5px; background-color:white; border-bottom: 1px solid black;" id="newEventBtn" class="btn" onclick="window.location.href='eventDetail.php'">Create New event</button>
        </li>
        <li>
          <button style="width:100%; height:35px; border: 0px; background-color:white; border-bottom: 1px solid black;" id="myPageBtn" class="btn" onclick="window.location.href='mypage.php'">My page</button>
        </li>
        <li><form id="logoutBtn" method="post" action="logout.php">
              <button style="width:100%; height:22px; border: 0px; padding-top: 5px; background-color:white; " class="btn">Log Out</button>
            </form>
        </li>
      </ul>
    </div> 
  </div>

  <div class="left-side">

    <div id="aboutPart" style="background-color:#ffeecc; border:1px solid #000;">
      <img src="img/question.png" width="100%" height="80%" alt="about" style="margin-left: auto;
            margin-right: auto;
            margin-top: 2%;
            margin-bottom: 2%;
            display: block;">
      <div class="text-center">
        <a href="question.html"><button type="button" class="btn btn-secondary">About EVEV</button></a>
      </div>
    </div>

    <!--Search field-->
    <div class="searching" style="background-color:#ffeecc; border:1px solid #000;">
      <div class="form-group">
        <!--<h4 style="text-align:center; padding-top:2%">Search by keyword</h4>-->
        <input type="text" class="form-control" id="searchid">
        <div class="text-center">
          <button type="button" class="btn btn-primary" style="margin-top:2%" onclick="searchEvent(loginState)">Search</button>
        </div>
      </div>
    </div>

    <!--category field-->
    <div class="category" style="background-color:#ffeecc; border:1px solid #000; ">
      <h4 style="text-align:center; padding-top:2%">C A T E G O R Y</h4>
      <div class="form-check" style="margin-left:10%">
        <label class="form-check-label">
          <input type="radio" checked="checked" class="form-check-input" value="" name="fooby[1][]" id="allCat" onclick="resetDB(loginState)">A L L
        </label>
      </div>
      <div class="form-check" style="margin-left:10%">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" value="" name="fooby[1][]" id="ca1" onclick="searchEventByCat('BBQ', loginState)">B B Q
        </label>
      </div>
      <div class="form-check" style="margin-left:10%">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" value="" name="fooby[1][]" id="ca2" onclick="searchEventByCat('CLUB', loginState)">C L U B
        </label>
      </div>
      <div class="form-check" style="margin-left:10%">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" value="" name="fooby[1][]"  id="ca3" onclick="searchEventByCat('MEET-UP', loginState)">M E E T - U P
        </label>
      </div>
      <div class="form-check" style="margin-left:10%">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" value="" name="fooby[1][]" id="ca4" onclick="searchEventByCat('CASUAL-LUNCH', loginState)">C A S U A L - L U N C H
        </label>
      </div>
      <div class="form-check" style="margin-left:10%">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" value="" name="fooby[1][]" id="ca5" onclick="searchEventByCat('PARTY', loginState)">P A R T Y
        </label>
      </div>
    </div>
      
    <!--Weather report section-->
    <div class="show" style="background-color:#ffeecc; border:1px solid #000; text-align:center;">
    <h5 style="margin-top:10%;">Brisbane Weather Forecast</h5>
    <br>
    <div id="forecast">
      <div class="pt5">Max temperature: <span id="max_temp"></span>&degC</div><br>
      <div>Min temperature: <span id="min_temp"></span>&degC</div>
      <img id="weatherIcon" alt="Weather Icon">
    </div>
    </div>

  </div>

  <!--Organisation selector-->
  <div class="right-side">
    <div class="navigation">
          <button type="button" class="navBtn" style="background-color:#7030A0;" onclick="searchEventByOrg('UQ', loginState)">U Q</button>
          <button type="button" class="navBtn" style="background-color:#C00000;" onclick="searchEventByOrg('Griffith', loginState)">Griffith</button>
          <button type="button" class="navBtn" style="background-color:#2F5597;" onclick="searchEventByOrg('QUT', loginState)">Q U T</button>
          <button type="button" class="navBtn" style="background-color:#548235;" onclick="searchEventByOrg('Other', loginState)">Other</button>
    </div>

    <hr style="border-width: 5px;" color="#0000ff">

    <!--Content creator-->
    <div class='w100 mauto'><div class='loader' id='eventLoader'></div></div>
    <div id="mainContent" class="content" style="width:100%; height:87%; overflow:auto; border:1px solid #000000;">
    </div>
  </div>

  <div class="container">
  
  <div class="modal fade" id="mapModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title" id="mapTitle"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div id="map" style="width: 100%; height:500px"></div>
      </div>
    </div>
  </div>

  <section id="hiddenEventData" style="display:none"></section>

  <section id="hiddenSQLdatabase" style="display:none">
    <?php 
        $DBusername = "root";
        $DBpassword = "pass1234";
        $DBName = "evev";

        include('connectMySQL.php');
        $db = new MySQLDatabase();
        $db->connect($DBusername, $DBpassword, $DBName);

        //Test to retreive recores of user
        $query = "SELECT * FROM event";
        $result = mysqli_query($db->link, $query);
        $totalResult=array();
        if($result) {
          while($row = mysqli_fetch_array($result)) {
            $totalResult[]=$row;
          }
          echo json_encode($totalResult);
        } else {
          die(mysqli_error($db->link)); // useful for debugging
        } 

        //$db-disconnect();

      ?>
  </section>

  <footer>
    <hr style="border-width: 5px;" color="#990000;">
    <div class="row">

      <div class="col-4">
        <img src="img/footerlogo.png"  style="margin-top:5%;" alt="EVEV title" width="100%">
      </div>

      <div class="col-8">

        <div class="row">

          <div class="col-4">
              <h6 class="row pt5 pb10"><a href='https://www.griffith.edu.au' style="color:black">Griffith</a></h6>
              <h6 class="row pt5 pb10"><a href='https://www.uq.edu.au' style="color:black">U Q</a></h6>
              <h6 class="row pt5 pb10"><a href='https://www.qut.edu.au' style="color:black">Q U T</a></h6>
          </div>

          <div class="col-4">
              <h6 class="row pt5 pb10"><a href='index.php' style="color:black">E V E V</a></h6>
              <h6 class="row pt5 pb10"><a href='question.html' style="color:black">A B O U T</a></h6>
              <h6 class="row pt5 pb10" style="margin-left: 40%;">&copy;Copyright 2018</h6>
          </div>

          <div class="col-4">
              <h6 class="row pt5 pb10"><a href='https://www.google.com.au/maps/' style="color:black">Google Map</a></h6>
              <h6 class="row pt5 pb10"><a href="http://www.bom.gov.au/qld/forecasts/brisbane.shtml" style="color:black">Weather</a></h6>
          </div>

        </div>
      </div>
    </div>
   </footer>

  <!-- Script tag -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script async defer
  src ="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1U092gDB4Zk9gPOIGrel8gHAb8IEVhK8">
  </script>
  <script src="facebook.js"></script>
  <script src="mainCustom.js"></script>
  <script type="text/javascript">
    var loginState = "<?php echo $_SESSION['loginState'];?>";
    changeByLoginState(loginState);
    function gettingWeather(){

      $.getJSON("https://api.apixu.com/v1/forecast.json?key=11c60066538e4c09a5d41248182505&q=Brisbane",function(json){
          var jsonForecast = json["forecast"]["forecastday"][0]["day"];
          var max = jsonForecast["maxtemp_c"];
          var min = jsonForecast["mintemp_c"];
          var wi = jsonForecast["condition"]["icon"];
          $("#max_temp").html(max);
          $("#min_temp").html(min);
          $("#weatherIcon").attr("src", wi);
      });
    }; 

    gettingWeather();
    var jsonEventData = JSON.parse($("#hiddenSQLdatabase").html());
    createEventSection(jsonEventData,  loginState);
  </script>

  <?php $db-disconnect();?>
</body>

</html>
