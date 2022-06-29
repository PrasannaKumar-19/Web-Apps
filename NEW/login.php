<!Doctype html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <form method="POST" action="login.php" id="login-form" class="login-form" autocomplete="off" role="main">
        <figure aria-hidden="true">
            <div class="person-body"></div>
            <div class="neck skin"></div>
            <div class="head skin">
                <div class="eyes"></div>
                <div class="mouth"></div>
            </div>
            <div class="hair"></div>
            <div class="ears"></div>
            <div class="shirt-1"></div>
            <div class="shirt-2"></div>
        </figure>
        <h1 class="a11y-hidden">Login</h1>
        <div>
            <label class="label-email">
                <input type="text" class="text" name="username" placeholder="Username" tabindex="1" required />
                <span class="required">Username</span>
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
        <div class="email">
            <a href="forgotPassword.php">Forgot password?</a>
        </div>
        <input type="submit" name="submit" value="Log In" />
        <div class="email">
            <a href="register.php">not a user sign up?</a>
        </div>

    </form>
</body>

</html>
<?php
include 'all.php';
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM login WHERE username = '" . $username . "' limit 1";
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $pass = implode(array_slice($user_data, 1, 1));
        $role = implode(array_slice($user_data, 2, 1));
        $name = implode(array_slice($user_data, 3, 1));
        $phno = implode(array_slice($user_data, 4, 1));
        $email = implode(array_slice($user_data, 5, 1));
        if ($password == $pass) {
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $pass;
            $_SESSION["role"] = $role;
            $_SESSION["name"] = $name;
            $_SESSION["phno"] = $phno;
            $_SESSION["email"] = $email;
            echo '<script> alert("Login sucessful")</script>';
            header("Location: " . $role . ".php");
        } else {
            echo '<script> alert("Incorrect Password")</script>';
            //echo '<script>history.back(-1)</script>';
        }
    } else {
        echo '<script> alert("Incorrect Username")</script>';
        //echo '<script>history.back(-1)</script>';

    }
}

?>