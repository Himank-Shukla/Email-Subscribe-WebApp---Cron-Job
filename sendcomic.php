<?php
// include_once '/config.php';
echo "aaaaaa";
$conn = mysqli_connect('localhost', 'root', 'root', 'users');
if($conn == false){
    dir('Error: Cannot connect');
}

$url='https://c.xkcd.com/random/comic/';
$headers=get_headers($url,1);
$unparsedurl=$headers['Location'][0]; 
$parsedurl= parse_url($unparsedurl,PHP_URL_PATH);
$code=filter_var($parsedurl, FILTER_SANITIZE_NUMBER_INT);
$url = 'https://xkcd.com/'.$code.'/info.0.json'; 
$imgdata = file_get_contents($url); 
$char = json_decode($imgdata);
$image=$char->img;

$sql = "SELECT email, name, hash FROM users WHERE active is NOT NULL";
$stmt=mysqli_query($conn,$sql);
$rows = array();






include('smtp/PHPMailerAutoload.php');
$html='Msg';
//  smtp_mailer('himankshukla808@gmail.com','subject',$html);
function smtp_mailer($to,$subject, $msg){
    $mail = new PHPMailer(); 
    // $mail->SMTPDebug  = 3;
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; 
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Username = "hkyyggv@gmail.com";
    $mail->Password = "password";
    $mail->SetFrom("hkyyggv@gmail.com");
    $mail->ClearAllRecipients();
    $mail->Subject = $subject;
    $mail->Body =$msg;
    $mail->AddAddress($to);
    $mail->addStringAttachment(file_get_contents($image),'xkcd.png'); 
    $mail->SMTPOptions=array('ssl'=>array(
        'verify_peer'=>false,
        'verify_peer_name'=>false,
        'allow_self_signed'=>false
    ));
    // if(!$mail->Send()){
    //     // echo $mail->ErrorInfo;
    //     $msg = 'Verifification email failed, try again later!';
    //     $color = 'color:red;';
    // }else{
    //     $msg = 'Already subscribed with this email!';
    //     $color = 'color:red;';
    //     return 'Sent';
    // }
    $mail->Send();
}













// $mail->addStringAttachment(file_get_contents($image),'xkcd.png');         
// $mail->isHTML(true);                                  
// $mail->Subject = 'XKCD Comic';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $verify = 'https';
} else {
    $verify = 'http';
}
while($row = mysqli_fetch_assoc($stmt)){

    smtp_mailer($row['email'],'XKCD Comic','Your free copy of  XKCD is attached. Have fun!<br><br> <img src='.$image.'> <br><br> <a href='.$verify.'://'.$_SERVER['HTTP_HOST'].'/xkcdMailer-main/unsubs.php?id='.$row['hash'].'>Click here to Unsubscribe.</a>'."\r\n");


    // $mail->ClearAllRecipients();
    // $mail->addAddress($row['email'], $row['name']);
    // $mail->Body = 'Your free copy of  XKCD is attached. Have fun!<br><br> <img src='.$image.'> <br><br> <a href='.$verify.'://'.$_SERVER['HTTP_HOST'].'/unsubs.php?id='.$row['hash'].'>Click here to Unsubscribe.</a>'."\r\n" ;
    // echo $row['email']."  name:". $row['name']."   ";
    // $mail->Send();
}
?>
