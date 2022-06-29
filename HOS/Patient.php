<!Doctype html>
<html>

<head>
    <title>index</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <br>
    <form action="Patient.php" method="POST" id="login-form" class="login-form" autocomplete="off" role="main">
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
            <center><label class="label-email">
                    <?php
                    include 'all.php';
                    $name = $_SESSION["name"];
                    $role = $_SESSION["role"];
                    if ($name == null) {
                        //header("Location: login.php");
                        echo '<script>
                            if(alert("login please")){}
                            else    
                                window.location = "login.php";
                        </script>';
                    }
                    echo "Welcome " . $name . " ";
                    ?>
                </label>

                <input type="submit" name="op" value="Put Appoinment"><br>
                <input type="submit" name="doc" value="View Doctors"><br>
                <input type="submit" name="appoinments" value="previous appoinments"><br>
                <input type="submit" name="visit" value="previous visits"><br>
                <input type="submit" name="bill" value="mybills"><br>
                <input type="submit" Value="Logout" name="logout">
            </center>
        </div>
    </form>
</body>

</html>

<?php
if (isset($_POST['doc'])) {
    $sql = "Select * from login where role='Doctor'";
    $result = mysqli_query($con, $sql);
    echo "<table>";
    if (mysqli_num_rows($result) >  0) {
        echo "<tr> <th>Name</th> <th>Phno</th> <th>Email</th> </tr>";
        while ($rows = mysqli_fetch_assoc($result)) {
            echo "<tr> 
                        <td>" . $rows["name"] . "</td>
                        <td>" . $rows["phno"] . "</td>
                        <td>" . $rows["email"] . "</td>
                    </tr>";
        }
        echo "</table>";
    } else {
        echo '<h5 style="color:Tomato">No Data Found</h5>';
    }
} else if (isset($_POST['appoinments'])) {
    $sql = "Select * from appoinment where patientName ='" . $_SESSION["name"] . "'; ";
    $result = mysqli_query($con, $sql);
    echo "<table>";
    if (mysqli_num_rows($result) >  0) {
        echo "<tr> <th>Name</th> <th>Doctorname</th> <th>Sympotoms</th> <th>Phno</th> <th>Email</th> <th>VisitDate</th> <th>VisitTime</th> </tr>";
        while ($rows = mysqli_fetch_assoc($result)) {
            echo "<tr> 
                        <td>" . $rows["patientName"] . "</td>
                        <td>" . $rows["doctorName"] . "</td>
                        <td>" . $rows["Symptoms"] . "</td>
                        <td>" . $rows["phno"] . "</td>
                        <td>" . $rows["email"] . "</td>
                        <td>" . $rows["visitDate"] . "</td>
                        <td>" . $rows["visitTime"] . "</td>
                    </tr>";
        }
        echo "</table>";
    } else {
        echo '<h5 style="color:Tomato">No Data Found</h5>';
    }
} else if (isset($_POST['visit'])) {
    $sql = "Select * from doctorvisit where patientName ='" . $_SESSION["name"] . "'; ";
    $result = mysqli_query($con, $sql);
    echo "<table>";
    if (mysqli_num_rows($result) >  0) {
        echo "<tr> <th>Id</th> <th>PatientName</th> <th>DoctorName</th> <th>VisitTime</th><th>symptoms</th> <th>medicine</th> <th>count</th> <th>inTake</th> <th>Status</th> </tr>";
        while ($rows = mysqli_fetch_assoc($result)) {
            echo "<tr> 
                        <td>" . $rows["id"] . "</td>
                        <td>" . $rows["patientName"] . "</td>
                        <td>" . $rows["doctorName"] . "</td>
                        <td>" . $rows["visitTime"] . "</td>
                        <td>" . $rows["Symptoms"] . "</td>
                        <td>" . $rows["Medicine"] . "</td>
                        <td>" . $rows["medCount"] . "</td>
                        <td>" . $rows["inTake"] . "</td>
                        <td>" . $rows["status"] . "</td>
                    </tr>";
        }
        echo "</table>";
    } else {
        echo '<h5 style="color:Tomato">No Data Found</h5>';
    }
} else if (isset($_POST['bill'])) {
    $sql = "Select * from bill where name ='" . $_SESSION["name"] . "'; ";
    $result = mysqli_query($con, $sql);
    echo "<table>";
    if (mysqli_num_rows($result) >  0) {
        echo "<tr> <th>Id</th> <th>Name</th> <th>billTime</th> <th>items</th><th>ServiceCharge</th> <th>medFee</th> <th>Total</th></tr>";
        while ($rows = mysqli_fetch_assoc($result)) {
            echo "<tr> 
                        <td>" . $rows["id"] . "</td>
                        <td>" . $rows["name"] . "</td>
                        <td>" . $rows["billDate"] . "</td>
                        <td>" . $rows["items"] . "</td>
                        <td>" . $rows["serviceCharge"] . "</td>
                        <td>" . $rows["medFee"] . "</td>
                        <td>" . $rows["total"] . "</td>
                    </tr>";
        }
        echo "</table>";
    } else {
        echo '<h5 style="color:Tomato">No Data Found</h5>';
    }
} else if (isset($_POST["op"])) {
    echo '<script>window.location = "Appoinment.php";</script>';
} else if (isset($_POST["logout"])) {
    header("Location: logout.php");
}
?>