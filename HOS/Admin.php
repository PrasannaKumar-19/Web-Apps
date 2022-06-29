<!Doctype html>
<html>

<head>
    <title>index</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <form action="Admin.php" method="POST" id="login-form" class="login-form" autocomplete="off" role="main">
        <div>
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
            <center>
                <label class="label-email">
                    <?php
                    include 'all.php';
                    $username = $_SESSION["username"];
                    $role = $_SESSION["role"];
                    if ($username == null) {
                        //header("Location: login.php");
                        echo '<script>
                            if(alert("login please")){}
                            else    
                                window.location = "login.php";
                        </script>';
                    }
                    echo "Welcome " . $username . "";
                    ?>
                </label>
                <input type="submit" name="add" value="Add Doctor/Admin"><br>
                <input type="submit" name="allUsers" Value="View All Users"><br>
                <input type="submit" name="allAppoinments" Value="View All appoinments"><br>
                <input type="submit" name="allVisits" Value="View All doctor meets"><br>
                <input type="submit" name="allMeds" Value="View All Meds"><br>
                <input type="submit" name="logout" Value="Logout">
            </center>
        </div>
    </form>
</body>

</html>

<?php
if (isset($_POST['allUsers'])) {
    $sql = "Select * from login";
    $result = mysqli_query($con, $sql);
    echo "<table border='1'>";
    if (mysqli_num_rows($result) >  0) {
        echo "<tr> <th>Username</th> <th>Password</th> <th>Role</th> <th>Name</th> <th>Phno</th> <th>Email</th> </tr>";
        while ($rows = mysqli_fetch_assoc($result)) {
            echo "<tr> 
                        <td>" . $rows["username"] . "</td>
                        <td>" . $rows["password"] . "</td>
                        <td>" . $rows["role"] . "</td>
                        <td>" . $rows["name"] . "</td>
                        <td>" . $rows["phno"] . "</td>
                        <td>" . $rows["email"] . "</td>
                    </tr>";
        }
        echo "</table>";
        echo '<form action = "admin.php" method="POST">
                    <input type="submit" name="delete" value="delete user">
                    </form>';
    } else {
        echo '<h5 style="color:Tomato">No Data Found</h5>';
    }
} else if (isset($_POST['allAppoinments'])) {
    $sql = "Select * from appoinment";
    $result = mysqli_query($con, $sql);
    echo "<table border='1'>";
    if (mysqli_num_rows($result) > 0) {
        echo "<tr> <th>patientName</th> <th>phno</th> <th>email</th> <th>Symptoms</th> <th>AT</th> <th>visitDate</th> <th>visitTime</th> <th>status</th> </tr>";
        while ($rows = mysqli_fetch_assoc($result)) {
            echo "<tr> 
                        <td>" . $rows["patientName"] . "</td>
                        <td>" . $rows["phno"] . "</td>
                        <td>" . $rows["email"] . "</td>
                        <td>" . $rows["Symptoms"] . "</td>
                        <td>" . $rows["AT"] . "</td>
                        <td>" . $rows["visitDate"] . "</td>
                        <td>" . $rows["visitTime"] . "</td>
                        <td>" . $rows["status"] . "</td>
                    </tr>";
        }
        echo "</table>";
    } else {
        echo '<h5 style="color:Tomato">No Data Found</h5>';
    }
} else if (isset($_POST['allVisits'])) {
    $sql = "Select * from doctorVisit";
    $result = mysqli_query($con, $sql);
    echo "<table border='1'>";
    if (mysqli_num_rows($result) > 0) {
        echo "<tr> <th>doctorName</th> <th>patientName</th> <th>visitTime</th> <th>Symptoms</th> <th>Medicine</th> <th>	fees</th> <th>medCount</th> <th>inTake</th> <th>remarks</th> <th>diet</th> <th>status</th> <th>appoinmentid</th> </tr>";
        while ($rows = mysqli_fetch_assoc($result)) {
            echo "<tr> 
                        <td>" . $rows["doctorName"] . "</td>
                        <td>" . $rows["patientName"] . "</td>
                        <td>" . $rows["visitTime"] . "</td>
                        <td>" . $rows["Symptoms"] . "</td>
                        <td>" . $rows["Medicine"] . "</td>
                        <td>" . $rows["fees"] . "</td>
                        <td>" . $rows["medCount"] . "</td>
                        <td>" . $rows["inTake"] . "</td>
                        <td>" . $rows["remarks"] . "</td>
                        <td>" . $rows["diet"] . "</td>
                        <td>" . $rows["status"] . "</td>
                        <td>" . $rows["appoinmentid"] . "</td>
                    </tr>";
        }
        echo "</table>";
    } else {
        echo '<h5 style="color:Tomato">No Data Found</h5>';
    }
} else if (isset($_POST['allMeds'])) {
    $sql = "Select * from tablets";
    $result = mysqli_query($con, $sql);
    echo "<table border='1'>";
    if (mysqli_num_rows($result) > 0) {
        echo "<tr> <th>medName</th> <th>medCount</th> <th>medCost</th> </tr>";
        while ($rows = mysqli_fetch_assoc($result)) {
            echo "<tr> 
                        <td>" . $rows["medName"] . "</td>
                        <td>" . $rows["medCount"] . "</td>
                        <td>" . $rows["medFee"] . "</td>
                    </tr>";
        }
        echo "</table>";
    } else {
        echo '<h5 style="color:Tomato">No Data Found</h5>';
    }
} else if (isset($_POST['delete'])) {
    echo '<script>var foo = prompt("Enter username");
                            if(foo!=null)
                                var bar = confirm("Confirm delete user");
                          document.cookie="pass="+foo;
                          </script>';
    $new =  $_COOKIE['pass'];
    $sql = "delete from login where username = '". $new ."' ";
    mysqli_query($con, $sql);
} else if (isset($_POST['add'])) {
    header("Location: adminRegister.php");
}
else if (isset($_POST["logout"])) {
    header("Location: logout.php");
}
?>