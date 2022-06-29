<!doctype html>
<html>

<head>
    <title>Signup</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <form action="register.php" method="POST" id="login-form" class="login-form" autocomplete="off" role="main">
        <h1 class="a11y-hidden">Registration</h1>
        <div>
            <label class="label-email">
                <input type="text" class="text" name="username" placeholder="username" tabindex="1" required />
                <span class="required">Username</span>
            </label>
        </div>
        <div>
            <label class="label-email">
                <input type="text" class="text" name="name" placeholder="name" tabindex="1" required />
                <span class="required">Name</span>
            </label>
        </div>
        <input type="checkbox" name="show-password" class="show-password a11y-hidden" id="show-password" tabindex="3" />
        <label class="label-show-password" for="show-password">
            <span>Show Password</span>
        </label>
            <div>
                <label class="label-password">
                    <input type="text" class="text" name="password" placeholder="Password" tabindex="2" required />
                    <span class="required">Password</span>
                </label>
            </div>
            <div>
                <label class="label-password">
                    <input type="text" class="text" name="password1" placeholder="Confirm Password" tabindex="2" required />
                    <span class="required">Confirm Password</span>
                </label>
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
                    <span class="required">phone Number</span>
                </label>
            </div>
            <div>
                <label class="label-email">
                    <input type="text" class="text" name="role" value="Patient" tabindex="1" disabled />
                    <span class="required">role </span>
                </label>
            </div>
            <input type="submit" value="Sign Up" name="register">

            <div class="email">
                <a href="login.php">Already a user login?</a>
            </div>
    </form>
</body>

</html>

<?php
include 'all.php';
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password1 = $_POST['password1'];
    $email = $_POST['email'];
    $phno = $_POST['phno'];
    $name = $_POST['name'];
    $role = "Patient";
    $sql = "SELECT password FROM login WHERE username = '" . $username . "' limit 1";
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        echo '<script> alert("Username already exist")</script>';
        //echo '<script>history.back(-1)</script>';
    } else {
        if ($password == $password1) {
            $sql = "Insert into login (username,password,role,email,phno,name) values('" . $username . "','" . $password . "','" . $role . "','" . $email . "'," . $phno . ",'" . $name . "');";
            if (mysqli_query($con, $sql)) {
                echo '<script>
                            if(alert("Sucessfully signed up click ok to login")){}
                            else    
                                window.location = "login.php";
                        </script>';
            } else {
                echo "Error: " . $sql . "" . mysqli_error($con);
            }
        } else {
            echo '<script> alert("passwords doesnot match")</script>';
        }
    }
}
?>