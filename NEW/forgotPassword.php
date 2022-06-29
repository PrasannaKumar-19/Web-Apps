<html>
    <head>
        <title>Forgot password</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <form action="forgotPassword.php" method="POST"  id="login-form" class="login-form" autocomplete="off" role="main">
        <div class="parent">
            <img src="images.png" alt="lock" style="background-color:transparent;">
        </div>
        <div>
            <label class="label-email">
                <input type="email" class="text" name="email" placeholder="Email" tabindex="1" required />
                <span class="required">Email</span>
            </label>
        </div>
        <div>
            <label class="label-email">
                <input type="text" class="text" name="phno" placeholder="Phone Number" tabindex="1" required />
                <span class="required">Phone Number</span>
            </label>
        </div>
        <input type="submit" value="Reset" name="reset">
        </form>
    <body>
</html>

<?php
    include "all.php";
    if(isset($_POST['reset'])){
        $email = $_POST['email'];
        $phno = $_POST['phno'];
        $_SESSION['changeEmail'] = $email;
        $sql = "select * from login where email = '".$email."' and phno = ".$phno." ";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result) > 0){
            echo '<script>var foo = prompt("Type new password");
                          var bar = confirm("Confirm reset password");
                          document.cookie="pass="+foo;
                          </script>';
            $new =  $_COOKIE['pass'];
            $sql = "update login set password='".$new."' where email= '".$email."' ";
            if(mysqli_query($con,$sql)){
                echo'<script>
                            if(alert("Reset sucessful click ok to login")){}
                            else    
                                window.location = "login.php";
                        </script>';

            }
        }
        else{
            echo '<script>alert("Invalid credentials"); </script>';
        }
    }
?>