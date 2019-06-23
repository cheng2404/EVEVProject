<?php 
    session_start();
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

    $emailBtnName = key($_POST);
    $eventID = substr($emailBtnName, 9);
    $username = $_SESSION['uname'];

    $DBusername = "root";
    $DBpassword = "pass1234";
    $DBName = "evev";

    include('connectMySQL.php');
    $db = new MySQLDatabase();
    $db->connect($DBusername, $DBpassword, $DBName);

    $queryUser = "SELECT username, email FROM user WHERE username='$username'";
    $resultUser = mysqli_query($db->link, $queryUser);
    $userInfo =array();
    if($resultUser) {
        while($row = mysqli_fetch_array($resultUser)) {
        $userInfo[]=$row;
    }
    } else {
      die(mysqli_error($db->link)); // useful for debugging
    }
    $userEmail = $userInfo[0]['email'];

    $queryEvent = "SELECT * FROM event WHERE eventID='$eventID'";
    $resultEvent = mysqli_query($db->link, $queryEvent);
    $eventInfo =array();
    if($resultEvent) {
        while($row = mysqli_fetch_array($resultEvent)) {
        $eventInfo[]=$row;
    }
    } else {
      die(mysqli_error($db->link)); // useful for debugging
    }
    $eventTitle = $eventInfo[0]['name'];
    $holderID = $eventInfo[0]['holderID'];

    $queryHolder = "SELECT id, username, email FROM user WHERE id='$holderID'";
    $resultHolder = mysqli_query($db->link, $queryHolder);
    $holderInfo =array();
    if($resultHolder) {
        while($row = mysqli_fetch_array($resultHolder)) {
        $holderInfo[]=$row;
    }
    } else {
      die(mysqli_error($db->link)); // useful for debugging
    }
    $holdername = $holderInfo[0]['name'];
    $holderEmail = $holderInfo[0]['email'];

	require_once('phpMailer.php');
	require_once('SMTP.php');
	require_once('Exception.php');
    $subject = "About: " . $eventTitle . "(" . $eventID .")" . " from EVEV";
    $body = 'I am interested in this event, please give me more details.<br><br>' . $username;
	$mail = new PHPMailer(true);

	try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mailhub.eait.uq.edu.au';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = false;                               // Enable SMTP authentication
    $mail->Port = 25;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom($userEmail, $username);
    $mail->addAddress('c.bao@uq.net.au', 'Owner');
    $mail->addAddress($holderEmail, $holdername);      // Add a recipient

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = $body;

    $mail->send();
    echo 'Message has been sent';
    header("Location: emailCompleted.html");
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
} 
?>