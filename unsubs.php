<!DOCTYPE html>
<html>
<style>
         .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
    }
</style>
<head>
    <title>XKCD Subscribe</title>
</head>

<body style="background-color:#6C7990;">
    <div id="header">
        <h3 style="text-align:center;">XKCD Comics Subscriber </h3>
    </div>
    <div id="wrap">

        <?php
        //  include_once '/config.php'; //_dir_ is faster but since dirname  is more widely used

        $conn = mysqli_connect('localhost', 'root', 'root', 'users');
        if($conn == false){
            dir('Error: Cannot connect');
        }


         if (isset($_GET['id']) && !empty($_GET['id'])) {
            $hash = $conn->real_escape_string($_GET['id']); 

            if ($conn->query("SELECT hash, active FROM users WHERE hash='" . $hash . "' AND active IS NOT NULL")->num_rows > 0) {
                
                $conn->query("UPDATE users SET active = NULL WHERE hash='".$hash."' AND active IS NOT NULL");
                $msg = 'Unsuscribed! You will not recieve anymore comics from now.</div>';
                $image='https://cdn.iconscout.com/icon/premium/png-256-thumb/unsubscribe-3313787-2794127.png';
                $color ='color:darkgreen;';
            }else{
                $msg = 'Already Unsubscribed or invalid request!</div>';
                $image = 'https://img.icons8.com/pastel-glyph/2x/error.png';
                $color ='color:darkred;';
            }
        }
        ?>

        <?php
            if (isset($image)) {  // Check if $msg is not empty
                echo ' <div class="imgcontainer"><img src= '.$image.' alt="Avatar" > </div>'; // Display our message and wrap it with a div with the class "statusmsg".
            }
            ?>
        <?php
            if (isset($msg)) {  // Check if $msg is not empty
                echo '<div style='.$color.' ><h4 style="text-align:center;">' . $msg . '</h3></div>'; // Display our message and wrap it with a div with the class "statusmsg".
            }
            ?>
    </div>
</body>
        
</html>