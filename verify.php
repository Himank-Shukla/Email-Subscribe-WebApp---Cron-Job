<!DOCTYPE html>
<html>
    <style>
         .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
    }
    /*set image properties*/
      
    /*set padding to the container*/
      
    .container {
        padding: 16px;
    }
    </style>
<head>
    <title>XKCD Subscribe</title>
</head>

<body style="background-color:#6C7990;">
    <div id="header">
        <h3 style="text-align:center;">XKCD Comics  Subscriber</h3>
    </div>
    <div id="wrap">
        
        <?php

        // include '/config.php';
        $conn = mysqli_connect('localhost', 'root', 'root', 'users');
        if($conn == false){
            dir('Error: Cannot connect');
        }
        
        if (isset($_GET['id']) && !empty($_GET['id'])) {
          
            $hash = $conn->real_escape_string($_GET['id']); // Set hash variable
            if ($search = $conn->query("SELECT hash, active FROM users WHERE hash='" . $hash . "' AND active IS NULL")) {
                $count = $search->num_rows;
                echo "99999";
            }
            
            if ($count > 0) {       
              
                $conn->query("UPDATE users SET active='1' WHERE hash='".$hash."' AND active IS NULL");
                $msg = 'Your account has been activated! Enjoy free XKCD comics every 5 minutes.';
                $color ='color:darkgreen;';
                $image='https://cdn.iconscout.com/icon/free/png-256/verified-badge-1-866240.png';
            }else{
                $image = 'https://img.icons8.com/pastel-glyph/2x/error.png';
                $msg = 'Account already activated or Invalid request!';
                $color ='color:darkred;';
            }                   
        }else{
            $image = 'https://img.icons8.com/pastel-glyph/2x/error.png';
            $msg = 'Invalid Request, Please register!';
            $color ='color:darkred;';
        }
        ?>
        
        <?php
            if (isset($image)) {  // Check if $msg is not empty
                echo ' <div class="imgcontainer"><img src= '.$image.' alt="Avatar" > </div>'; // Display our message and wrap it with a div with the class "statusmsg".
            }
            ?>
        <?php
            if (isset($msg)) {  // Check if $msg is not empty
                echo '<div style='.$color.' ><h3 style="text-align:center;">' . $msg . '</h3></div>'; // Display our message and wrap it with a div with the class "statusmsg".
            }
            ?>

    </div>
</body>

</html>