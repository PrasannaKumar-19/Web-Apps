<!Doctype html>
<html>

<head>
    <title>index</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <form action="Doctor.php" method="POST" id="login-form" class="login-form" autocomplete="off" role="main">
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
                    $username = $_SESSION["name"];
                    $role = $_SESSION["role"];
                    if ($username == null) {
                        //header("Location: login.php");
                        echo '<script>
                            if(alert("login please")){}
                            else    
                                window.location = "login.php";
                        </script>';
                    }
                    echo "Welcome " . $username . " ";
                    ?>
                </label>

                <label class="label-email">Select Date</label>
                <span><input type="date" data-date="" data-date-format="YYYY-MM-DD" id="doo" name="doo"></span>
                <br>
                <input type="submit" name="pending" value="Pending Appoinments">
                <br>
                <input type="submit" name="completed" value="Completed Appoinments">
                <br>
                <input type="submit" name="visit" value="patienrVisit">
                <br>
                <input type="submit" name="logout" value="Logout">
            </center>
        </div>
    </form>
</body>

</html>


<?php
    
    if (isset($_POST['completed'])) {
        $date = strtotime($_POST["doo"]);
        $date2 = date('Y-m-d', $date);
        $sql = "SELECT *  FROM appoinment WHERE doctorName = '" . $_SESSION["username"] . "' and visitDate='" . $date2 . "' and status='Completed';";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result)>0) {
            echo "<table>";
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
    } elseif (isset($_POST['pending'])) {
        $date = strtotime($_POST["doo"]);
        $date2 = date('Y-m-d', $date);
        $sql = "SELECT patientName,phno,email,Symptoms,AT,visitDate,visitTime,status FROM appoinment WHERE doctorName = '" . $_SESSION["username"] . "' and visitDate='" . $date2 . "' and status='Pending';";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result)>0) {
            echo "<table>";
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
    }
    else if (isset($_POST["visit"])) {
        echo '<script>window.location = "patientVisit.php";</script>';
    } else if (isset($_POST["logout"])) {
        header("Location: logout.php");
    }

    ?>