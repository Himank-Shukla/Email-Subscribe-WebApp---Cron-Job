<!DOCTYPE html>
<html>
<style>
    /*set border to the form*/

    form {
        border: 3px solid #f1f1f1;
    }

    /*assign full width inputs*/

    input[type=text],
    input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    /*set a style for the buttons*/

    button {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    /* set a hover effect for the button*/

    button:hover {
        opacity: 0.8;
    }

    /*set extra style for the cancel button*/

    .cancelbtn {
        width: auto;
        padding: 10px 18px;
        background-color: #f44336;
    }

    /*centre the display image inside the container*/

    .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
    }

    /*set image properties*/

    img.avatar {
        width: 40%;
        border-radius: 50%;
    }

    /*set padding to the container*/

    .container {
        padding: 16px;
    }

    /*set the forgot password text*/

    span.psw {
        float: right;
        padding-top: 16px;
    }

    /*set styles for span and cancel button on small screens*/

    @media screen and (max-width: 300px) {
        span.psw {
            display: block;
            float: none;
        }

        .cancelbtn {
            width: 100%;
        }
    }
</style>

<head>
    <title>XKCD Subscribe</title>
</head>

<body>
    <div id="header">
        <h3 style="text-align:center;">XKCD Comics Subscriber</h3>
    </div>

    <div id="wrap">
    <?php
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
            // $mail->Username   = 'himank@gmail.com'; //put email here for phpmailer
            // $mail->Password   = 'emailPassword'; //put pasdword here for php mailer
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            // $mail->Port       = 587;
            // $mail->setFrom('Your mail Address here', 'XKCD Comic Subscription');
            // $mail->addReplyTo('Your email Address here', 'XKCD subscriber');
            










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
                $mail->Password = "clashofclans";
                $mail->SetFrom("hkyyggv@gmail.com");
                $mail->Subject = $subject;
                $mail->Body =$msg;
                $mail->AddAddress($to);
                $mail->SMTPOptions=array('ssl'=>array(
                    'verify_peer'=>false,
                    'verify_peer_name'=>false,
                    'allow_self_signed'=>false
                ));
                if(!$mail->Send()){
                    // echo $mail->ErrorInfo;
                    $msg = 'Verifification email failed, try again later!';
                    $color = 'color:red;';
                }else{
                    $msg = 'Already subscribed with this email!';
                    $color = 'color:red;';
                    return 'Sent';
                }
            }
        ?>







        <?php

        // include "/config.php";
        $color = 'color:green;';

        $name = $email  = "";
        if (isset($_POST['name']) && !empty($_POST['name']) and isset($_POST['email']) && !empty($_POST['email'])) {
            

            
            $name = $_POST['name'];
            $email = $_POST['email'];
            $hash = md5(rand(0, 1000));
            $count = 1;
            // echo "hohohoheeeeeeo";
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $msg = 'The email you have entered is invalid, please try again.';
                $color = 'color:red;';
            } else {
                // echo "hohohoheeeeeeo4";
                // check if email already exits in db
                // $query=mysqli_query($conn,"SELECT * FROM users WHERE email = '$email' and active is NOT NULL")or die(mysqli_error());
	            // $row= mysqli_fetch_array($query);
                // echo "hohohoheeeeeeo4";




                if ($result = mysqli_query($conn,"SELECT * FROM users WHERE email = '$email' and active is NOT NULL")or die(mysqli_error())) {
                    // echo "hohohohfffffff";
                    $count = $result->num_rows;
                }
                // echo "hohohohfffffff3333333333";
                // $count=0;
                if ($count == 0) {
                    //send email if new email
                    // echo "hohohoheeeeeeo1";
                    if ($conn->query("SELECT * FROM users WHERE email = '$email' and active is NULL")->num_rows == 1) {
                        echo "555555";
                        $conn->query("UPDATE users set name = '$name', hash = '$hash' where email = '$email'");
                        $msg = 'Verifification email has been resent, Name updated successfully!';
                        $color = 'color:green;';
                        // echo "hohohohfffffff3333333333";
                    } else {
                        echo "7777777";
                        mysqli_query($conn, "INSERT IGNORE INTO users (name, email, hash) VALUES('" . $name . "', '" . $email . "', '" . $hash . "') ");
                        $msg = 'Verifification email sent to '."$email".' successfully! Activate your account to enroll for comics.';
                        $color = 'color:green;';
                    }

                    // echo "888888";
                    // $mail->addAddress($email);
                    // echo "9999999";
                    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                        $verify = 'https';
                    } else {
                        $verify = 'http';
                    }
                    // echo "9999999";
                    $verify .= '://';
                    // echo "9999999";


                    smtp_mailer($email,'Account Verification ', 'Hello, ' . $name . '<br>Please verify your email to subscribe to XKCD Comics very 5 minutes for free.<br>'.$verify . $_SERVER['HTTP_HOST'] . '/xkcdMailer-main/verify.php?id=' . $hash . "\r\n");




                    // $mail->isHTML(true);
                //     echo "9999999";
                //     // $mail->Subject = 'Account Verification ';
                //     $mail->Body    = 'Hello, ' . $name . '<br>';
                //     $mail->Body    .= 'Please verify your email to subscribe to XKCD Comics very 5 minutes for free.<br> ';
                //     $mail->Body    .= $verify . $_SERVER['HTTP_HOST'] . '/verify.php?id=' . $hash . "\r\n";
                //     if (!$mail->Send()) {
                //         $msg = 'Verifification email failed, try again later!';
                //         $color = 'color:red;';
                //     }
                //   else {
                //         $msg = 'Already subscribed with this email!';
                //         $color = 'color:red;';
                //         echo "hohohohffff2222fff";
                //     }
                    
            }
        }
    }
        // }else{
        //     echo "hohohohfffffff";
        // }

        ?>
        <div class="form-group">
        </div>


        <!--Step 1 : Adding HTML-->
        <form action="" method="post">
            <div class="imgcontainer">
                <img src="https://xkcd.com/s/0b7742.png" alt="Avatar">
            </div>

            <div class="container">
                <label><b>Name</b></label>
                <input type="text" placeholder="Enter Name" name="name" required>

                <label><b>Email</b></label>
                <input type="text" placeholder="Enter Email Address" name="email" required>

                <?php
                if (isset($msg)) {  // Check if $msg is not empty
                    echo '<div style=' . $color . '>' . $msg . '</div>'; // Display our message and wrap it with a div with the class "statusmsg".
                }
                ?>

                <button type="submit">Subscribe</button>
            </div>

        </form>

</body>

</html>