<?php 
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	$contactName = $_REQUEST['name'];
    $contactEmail = $_REQUEST['email'];
    $contactMessage = $_REQUEST['message'];

    $subject = "Enquiry from" . $contactName;

	//Load Composer's autoloader
	require_once('phpMailer.php');
	require_once('SMTP.php');
	require_once('Exception.php');
	echo "sendEmail.php";
	$mail = new PHPMailer(true);
	try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mailhub.eait.uq.edu.au';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = false;                               // Enable SMTP authentication
    $mail->Port = 25;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom($contactEmail, $contactName);
    $mail->addAddress('c.bao@uq.net.au', 'Owner'); 

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $contactMessage;
    $mail->AltBody = $contactMessage;

    $mail->send();
    header("Location: emailCompleted.html");
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
} 

?>