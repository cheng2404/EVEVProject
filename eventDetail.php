<?php
$previousURI = $_SERVER['HTTP_REFERER'];
$isNewEvent = (strpos($previousURI, "mypage"))? false: true;

//Search event data in edit mode
if(!$isNewEvent) {
  $eventBtnName = key($_POST);
  $eventID = substr($eventBtnName, 8);

  $DBusername = "root";
  $DBpassword = "pass1234";
  $DBName = "evev";

  include('connectMySQL.php');
  $db = new MySQLDatabase();
  $db->connect($DBusername, $DBpassword, $DBName);

  $queryToSearch = "SELECT * FROM event WHERE eventID='$eventID'";
  $searchResult = mysqli_query($db->link, $queryToSearch);
  $eventInfo = array();

  if($searchResult) {
    while($row = mysqli_fetch_array($searchResult)) {
      $eventInfo[] = $row;
    }
  } else {
    die(mysqli_error($db->link)); // useful for debugging
  } 
} else {$eventID = "";}

$webTitle = ($isNewEvent) ? "Create New Event" : "Edit Event";
$eventTit = ($isNewEvent) ? "" : $eventInfo[0]["name"];
$eventCat = ($isNewEvent) ? "" : $eventInfo[0]["category"];
$eventOrg = ($isNewEvent) ? "" : $eventInfo[0]["organisation"];
$eventLoc = ($isNewEvent) ? "" : $eventInfo[0]["location"];
$eventDes = ($isNewEvent) ? "" : $eventInfo[0]["description"];
$eventDateTime = ($isNewEvent) ? "" : $eventInfo[0]["eventDateTime"];
$eventYear = substr($eventDateTime, 0, 4);
$eventMon = substr($eventDateTime, 5, 2);
$eventDate = substr($eventDateTime, 8, 2);
$eventHour = substr($eventDateTime, 11, 2);
$eventMin = substr($eventDateTime, 14, 2);
$eventImg = ($isNewEvent) ? "" : $eventInfo[0]["image1"];
$submitMsg = ($isNewEvent) ? "Create New Event" : "Save Event";
$actionPage = ($isNewEvent) ? "newEvent.php" : "save.php?eventID=" . $eventID;
$cancelPage = ($isNewEvent) ? "index.php" : "mypage.php";
?>

<!DOCTYPE html>
<html>
  <head>
  <style>
  body {
      text-align: center;
  }
  .wrap {
      width: 100%;
      display: inline-block;
  }
  .drag-drop-box{
      width: 100%;
      border:#DCDCDC solid 2px;
      border-radius: 0.5em;
      -moz-border-radius: 0.5em;
      -webkit-border-radius: 0.5em;
      margin: 0 auto 1.5em;
      overflow: hidden;
      position: relative;
  }

  .drag-block {
      width: 100%;
      padding-bottom: 75%;
      height: 0;
      background-color: black;
      position: relative;
      opacity: 0.5;
      visibility: hidden;
      z-index: 3;
  }

  .drag-drop-box .icon-camera, .drag-drop-box .drag-label {
      position: absolute;
      top: 50%;
      transform: translate(-50%, -50%);
      left: 50%;
  }

  .display-img {
      width: 100%;
  }

  .icon-camera {
      width: 30%;
  }

  .has-photo .icon-camera, .no-photo .display-img, .has-photo .drag-block, .has-photo .drag-label{
      display: none;
  }

  .has-photo .display-img, .no-photo .icon-camera{
      display: block;
  }

  .float-bar {
      width: 100%;
      height: 3.5em;
      -moz-opacity: 0.75;
      opacity: 0.75;
      background-color: #000000;
      position: absolute;
      bottom: -3.5em;
      display:flex;
      display: -webkit-flex;
      align-items:center;
      justify-content: center;
      color: #F4F8F9;
      z-index: 4;
  }

  .float-bar:hover{
      cursor: pointer;
      color: #e74c3c;
  }

  .drag-drop-box input[type="file"] {
      display: none;
  }

  .drag-label {
      color: white;
      display: none;
      z-index: 5;
  }
</style>

    <title>CreatNewEvent</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta name="keywords" content="weather,world,Openstreetmap,forecast, Openweather,current">
    <meta name="description" content="">
    <meta name="author" content="OpenWeatherMap.org">
    <meta name="domain" content="OpenWeatherMap.org">
    <meta http-equiv="pragma" content="no=cache">
    <meta http-equiv="Expires" content="=1">
    <meta name="p!domain_varify" content="34fe229eabB562dca90f4a5962ff80a9"/>
  </head>

  <body>
    <div class="header">
      <img src="img/upLog.png" alt="EVEV title" width="100%">
      <a href="index.php"><button class="btn" style="background:none; width: 320px; height:80px; border: 0; margin-top: -80px;"></button></a>
    </div>

  <div >
    <div class="mapTitle" width="100%" style="text-align:center">
      <h1><?php echo $webTitle; ?></h1>
    </div>
    <hr style="border-width: 5px;" color="#990000;">

  <form method="post" action="<?php echo $actionPage; ?>" enctype="multipart/form-data">

  <div class="content" style="margin-left:17%; margin-right:10%;" >

    <div class="form-group row">
      <label for="example-text-input" class="col-2 col-form-label">Title</label>
      <div class="col-10">
      <input name="title" value="<?php echo $eventTit;?>" class="form-control" type="text" placeholder="Put the event title" id="example-text-input" required>
      </div>
    </div>

    <div class="form-group">
      <label>Hold Time(hour:mins Day/Month/Year)</label>
      <div class="row">
          <div class="col-md-2" >
            <select name="hour" class="form-control" id="hourSelector">
              <option value="00">0</option>
              <option value="01">1</option>
              <option value="02">2</option>
              <option value="03">3</option>
              <option value="04">4</option>
              <option value="05">5</option>
              <option value="06">6</option>
              <option value="07">7</option>
              <option value="08">8</option>
              <option value="09">9</option>
              <option >10</option>
              <option>11</option>
              <option>12</option>
              <option>13</option>
              <option>14</option>
              <option>15</option>
              <option>16</option>
              <option>17</option>
              <option>18</option>
              <option>19</option>
              <option>20</option>
              <option>21</option>
              <option>22</option>
              <option>23</option>
            </select>
          </div>
      <div class="col-md-0.5" ><h4>:</h4></div>
      <div class="col-md-2" >
        <select name="minute" class="form-control" id="minSelector" >
          <option>00</option>
          <option>10</option>
          <option>20</option>
          <option>30</option>
          <option>40</option>
          <option>50</option>
          </select>
      </div>
      <div class="col-md-1" ><h4></h4></div>
      <div class="col-md-2" >
        <select name="date" class="form-control" id="dateSelector" type=”date”>
          <option value="01">1</option>
          <option value="02">2</option>
          <option value="03">3</option>
          <option value="04">4</option>
          <option value="05">5</option>
          <option value="06">6</option>
          <option value="07">7</option>
          <option value="08">8</option>
          <option value="09">9</option>
          <option>10</option>
          <option>11</option>
          <option>12</option>
          <option>13</option>
          <option>14</option>
          <option>15</option>
          <option>16</option>
          <option>17</option>
          <option>18</option>
          <option>19</option>
          <option>20</option>
          <option>21</option>
          <option>22</option>
          <option>23</option>
          <option>24</option>
          <option>25</option>
          <option>26</option>
          <option>27</option>
          <option>28</option>
          <option>29</option>
          <option>30</option>
          <option>31</option>
          </select>
      </div>
      <div class="col-md-0.5" ><h4>/</h4></div>
      <div class="col-md-2" >
        <select name="month" class="form-control" id="monthSelector" placeholder=type=”week”>
          <option value="01">1</option>
          <option value="02">2</option>
          <option value="03">3</option>
          <option value="04">4</option>
          <option value="05">5</option>
          <option value="06">6</option>
          <option value="07">7</option>
          <option value="08">8</option>
          <option value="09">9</option>
          <option>10</option>
          <option>11</option>
          <option>12</option>
          </select>
      </div>
      <div class="col-md-0.5" ><h4>/</h4></div>
      <div class="col-md-2" >
        <select name="year" class="form-control" id="yearSelector" placeholder="Mothes">
          <option>2018</option>
          <option>2019</option>
          <option>2020</option>
      </select>
      </div>
    </div>
  </div>

  <div class="form-group row">
    <label  class="col-2 col-form-label"> Category </label>
    <div class="col-10">
      <select name="category" class="form-control" id="categorySelector">
        <option></option>
        <option>BBQ</option>
        <option>CLUB</option>
        <option>MEET-UP</option>
        <option>CASUAL-LUNCH</option>
        <option>PARTY</option>
        <option>OTHERS</option>
      </select>
    </div>
  </div>

  <div class="form-group row">
    <label  class="col-2 col-form-label"> Organisation </label>
    <div class="col-10">
      <select name="organisation" class="form-control" id="orgSelector">
        <option></option>
        <option value="UQ">THE UNIVERSITY OF QUEENSLAND</option>
        <option value="QUT">THE QUEENSLAND UNIVERISTY OF TECHNOLOGY</option>
        <option value="Griffith">GRIFFITH UNIVERSITY</option>
        <option value="Others">OTHERS</option>
      </select>
    </div>
  </div>


  <div class="form-group row">
    <label for="example-text-input" class="col-2 col-form-label">Location</label>
    <div class="col-10">
      <input value="<?php echo $eventLoc;?>" name="location" class="form-control" type="text" placeholder="Put the event location" id="example-text-input">
    </div>
  </div>

  <div class="form-group">
    <label for="comment">Discription</label>
    <textarea name="descp" class="form-control" rows="5" id="ds" placeholder="Put some disciotion this event, help more people konw that !"><?php echo $eventDes;?></textarea>
  </div>

  <div class="picture">
    <input type="file" name="image1" id="image1">
  </div>

  <div class="row" style="margin: 40px 0 50px 0;">
  <div class="col-md-3" ><button type="button" class="btn btn-danger" style="margin-left: -50px;" onclick="window.location.href='<?php echo $cancelPage; ?>'">Cancel</button></div>
  <div class="col-md-3" ></div>
  <div class="col-md-3" ><div></div></div>
  <div class="col-md-3" >
  <div><button name="submit" style="margin-left: 50px;" type="submit" class="btn btn-success"><?php echo $submitMsg; ?></button></div>
  </div>
</div>

</form>


</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">

      var isNewMode = "<?php echo $isNewEvent;?>";
      if (isNewMode!=true) {
        $("#yearSelector").val("<?php echo $eventYear; ?>");
        $("#monthSelector").val("<?php echo $eventMon; ?>");
        $("#dateSelector").val("<?php echo $eventDate; ?>");
        $("#hourSelector").val("<?php echo $eventHour; ?>");
        $("#minSelector").val("<?php echo $eventMin; ?>");
        $("#orgSelector").val("<?php echo $eventOrg; ?>");
        $("#categorySelector").val("<?php echo $eventCat; ?>");
      }

    </script>
  <script>
    $(function () {
        $('.drag-drop-box').each(function () {
            var $uploadBox = $(this),
                isDropped = false,
                $input = $uploadBox.find('input[type="file"]'),
                $ic_camera = $uploadBox.find('.icon-camera'),
                $dropBlock = $uploadBox.find('.drag-block'),
                $blockLabel = $uploadBox.find('.drag-label'),
                $bar = $uploadBox.find('.float-bar'),
                $fileButton = $bar.find('strong'),
                $displayImg = $uploadBox.find('.display-img'),
                droppedFiles,
                uploadFile,
                showFile =
                    function (file_url) {
                        uploadFile = file_url;
                        var reader = new FileReader();
                        reader.onload = function (ev)
                        {
                            var url = ev.target.result;
                            $displayImg.attr('src', url);
                        };
                        reader.readAsDataURL(file_url);
                        isDropped = true;
                        $fileButton.text("Change");
                        $uploadBox
                            .removeClass('no-photo')
                            .addClass('has-photo');
                    };
            var filechangeFunc = function (ev)
            {
                var files = ev.target.files;
                if(files.length !== 0)
                    showFile(ev.target.files[0]);
            };
            $input.on('change', filechangeFunc);
            $fileButton.click(function (ev) {
                $input.trigger('click');
            });
            $uploadBox
                .on( 'drag dragstart dragend dragover dragenter dragleave drop', function( e )
                {
                    // preventing the unwanted behaviours
                    e.preventDefault();
                    e.stopPropagation();
                })
                .on( 'drop', function( e )
                {
                    droppedFiles = e.originalEvent.dataTransfer.files; // the files that were dropped
                    showFile(droppedFiles[0]);
                })
                .mouseenter( function (ev)
                {
                    if(!$uploadBox.hasClass('has-photo')){
                        $dropBlock.css('visibility', 'visible');
                        $ic_camera.css('visibility', 'hidden');
                        $blockLabel.css('display', 'block');
                    }
                    $bar.finish();
                    $bar.animate({
                        'bottom': "0"
                    });
                })
                .mouseleave( function (ev)
                {
                    $dropBlock.removeAttr('style');
                    $ic_camera.removeAttr('style');
                    $blockLabel.removeAttr('style');
                    $bar.finish();
                    $bar.animate({
                        'bottom': "-3.5em"
                    });
                });
        });
    });
</script>

  </body>
</html>
