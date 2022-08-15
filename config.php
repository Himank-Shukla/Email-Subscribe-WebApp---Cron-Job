<?php
//$serverName = "127.0.0.1";
//set_time_limit (120);

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
// use PHPMailer\PHPMailer\SMTP;

// include  '/PHPMailer/Exception.php';
// include  '/PHPMailer/PHPMailer.php';
// include  '/PHPMailer/SMTP.php';

$conn = mysqli_connect('localhost', 'root', 'root', 'users');
// mysqli_query($conn, "SET @@session.wait_timeout=28800");
// if (!mysqli_ping($conn)) {
//     $conn = mysqli_connect('localhost', 'root', 'root', 'users');
// }
// if (!$conn) {
//     echo 'failed to connect';
// }
if($conn == false){
    dir('Error: Cannot connect');
}

// $mail = new PHPMailer(true);

// $mail->isSMTP();
// $mail->Host       = 'smtp.gmail.com'; //smtp server used here
// $mail->SMTPAuth   = true;
// $mail->Username   = 'hkyyggv@gmail.com'; //put email here for phpmailer
// $mail->Password   = 'clashofclan'; //put pasdword here for php mailer
// $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
// $mail->Port       = 587;
// $mail->setFrom('hkyyggv@gmail.com', 'XKCD Comic Subscription');
// $mail->addReplyTo('hkyyggv@gmail.com', 'XKCD subscriber');
?>