<?php
session_start();
$username = $_SESSION['uname'];

if(!isset($_SESSION['uname']) && !isset($_SESSION['pws'])) {
  header("Location: index.php");
} 

$DBusername = "root";
$DBpassword = "pass1234";
$DBName = "evev";

include('connectMySQL.php');
$db = new MySQLDatabase();
$db->connect($DBusername, $DBpassword, $DBName);

//Get user login user information
$queryToSearchUser = "SELECT id, firstname, lastname, username, email FROM  user WHERE username='$username'";
$userResult = mysqli_query($db->link, $queryToSearchUser);
$userInfo=array();
if($userResult) {
  while($row = mysqli_fetch_array($userResult)) {
    $userInfo[]=$row;
  }
} else {
  die(mysqli_error($db->link)); // useful for debugging
} 
$userID = $userInfo[0]['id'];
$firstname = $userInfo[0]['firstname'];
$lastname = $userInfo[0]['lastname'];
$email = $userInfo[0]['email'];

//Get login user organised event data
$queryOrganised = "SELECT * from event WHERE holderID='$userID'";
$organisedResult = mysqli_query($db->link, $queryOrganised);
$organisedEvents=array();
if($organisedResult) {
  while($row = mysqli_fetch_array($organisedResult)) {
    $organisedEvents[]=$row;
  }
} else {
  die(mysqli_error($db->link)); // useful for debugging
}

//Get login user participate event data
$queryParticipate = "SELECT event.* FROM event, user, joinEventUser WHERE joinEventUser.joinEventID=event.eventID AND joinEventUser.joinUserID=user.id AND user.id='$userID'";
$participateResult = mysqli_query($db->link, $queryParticipate);
$participateEvents=array();
if($participateResult) {
  while($row = mysqli_fetch_array($participateResult)) {
    $participateEvents[]=$row;
  }
} else {
  die(mysqli_error($db->link)); // useful for debugging
} 

?>


<!DOCTYPE html>
<html>
  <head>
    <style>


    input{
      border:0px;
    }


    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }
    </style>

    <title>MyPage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>

  <body style="margin-bottom: 90px;">
  <div id="loginAlert" class="alert alert-danger" role="alert" style="display:none">
  Please login or sign up!!
  </div>

  <div class="header">
    <img src="img/upLog.png" alt="EVEV title" width="100%">
    <a href="index.php"><button class="btn" style="background:none; width: 320px; height:80px; border: 0; margin-top: -80px;"></button></a>
  </div>

  <div >
    <div class="MyPageTitle" width="100%" style="text-align:center">
      <h1>My Page</h1>
    </div>
  </div>


<div>
  <hr style="border-width: 5px;" color="#990000;">


<div>
<div class="container-fluid" style=" padding-left: 20%" id="inputField">
    <div class="row">
       <div class="col-md-3" ><h3>Username:</h3></div>
       <div class="col-md-9"><input type="text" style="font-size:150%;" class="input" id="username" value="<?php echo $username;?>" disabled = true></input></div>
     </div>
    <br>
    <div class="row">
     <div class="col-md-3" ><h3>Name:</h3></div>
     <div class="col-md-4">
      <div style="font-size:150%;"><?php echo $firstname; ?>&ensp;<?php echo $lastname; ?></div>
     </div>
   </div>
   <br>
     <div class="row">
       <div class="col-md-3" ><h3>Email:</h3></div>
       <div class="col-md-9"><input type="text" style="font-size:150%;"  class="input" id="Email" value="<?php echo $email;?>" disabled = true ></input></div>
     </div>
</div>
</div>
</div>

<br>
<br>


<div>
<!--button-->
  <div class="tab">
    <button class="tablinks" onclick="openDown(event, 'Or')" id="defaultOpen">Orgnised Event</button>
    <button class="tablinks" onclick="openDown(event, 'Pa')">Participator Event</button>
  </div>

<!--Orgnised Event-->
  <div id="Or" class="tabcontent" style="height: 620px;">
    <div id="organiseContent"class="content" style="width:100%; height:600px; overflow:auto; border:1px solid #000000;">
      
    </div>
  </div>

<!--Participator Event-->
      <div id="Pa" class="tabcontent" style="height: 620px;">
        <div id="participateContent" class="content" style="width:100%; height:600px; overflow:auto; border:1px solid #000000;">
      </div>

      </div>

    </div>
    <div class="button" style="width:100%; height:50px;">
      <a href="index.php"><button type="button" class="btn btn-success" style="float: right; margin-top:1%;" >Back to Home</button></a>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style=" border: 0px;">
              <button  type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="row">
              <div class="col-12">
                <h4 style="text-align: center;" > Dou you want delete this event?</h4>
              </div>
            </div>
              <form id="deleteForm" method="post">
              <div class="row" style="margin:5%;">
                <div class="col-6">
                <button type="button" class="btn btn-secondary"   style="width: 100%;" data-dismiss="modal">Close</button></div>
                <div class="col-6">
                <button name="" type="submit" class="btn btn-danger"  style="width: 100%;">Delete</button></div>
              </div>
              </form>
            </div>
          </div>
      </div>
    </div>

    <!-- Map Modal -->
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

    <section id="hiddenOrganisedEventData" style="display:none"><?php echo json_encode($organisedEvents);?></section>

    <section id="hiddenParticipateEventData" style="display:none"><?php echo json_encode($participateEvents);?></section>
    
    <script src="mainCustom.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script async defer
    src ="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1U092gDB4Zk9gPOIGrel8gHAb8IEVhK8">
    </script>

    <script>

    function setDeleteURI(ev) {
      var deleteBtnName = ev.target.name;
      var deleteEventID =  deleteBtnName.substring(10);
      var deleteURI = "delete.php?eventID=" + deleteEventID;
      $("#deleteForm").attr("action", deleteURI);
    }

    function disable() {
        jQuery("input").attr("disabled", "true")
        document.getElementById("change").style.display = "block";
        document.getElementById("save").style.display = "none";
        $("input").css('border', "solid 0px black");


    }

    function enable() {
        jQuery("input").removeAttr("disabled")
        document.getElementById("change").style.display = "none";
        document.getElementById("save").style.display = "block";
        $("input").css('border', "solid 1px black");
    }


    function openDown(evt, sectionName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(sectionName).style.display = "block";
        evt.currentTarget.className += " active";

        if(sectionName=="Or") {
          var jsonOrganisedEventData = JSON.parse($("#hiddenOrganisedEventData").html());
          createEventLists(jsonOrganisedEventData, "#organiseContent");
          $('button[name*="editBtn"]').each(function(){
              $(this).show();
          }); 
        } else {
          var jsonOrganisedEventData = JSON.parse($("#hiddenParticipateEventData").html());
          createEventLists(jsonOrganisedEventData, "#participateContent");
          $('button[name*="editBtn"]').each(function(){
              $(this).hide();
          }); 
        }
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();


    </script>

  <?php $db-disconnect();?>
  </body>
</html>
