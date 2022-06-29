<html>
    <script>
        debugger;
        function opDate(){
            var d = document.getElementById('doo').value;
            let date = new Date(d);
            let date1 = new Date();
            let day = date.toLocaleString('en-us', {weekday: 'long'});
            if(day.localeCompare("Sunday") == 0){
                alert("Doctors not availabe during Sundays");
            }
            var day1 = date.getDate();
            var day2 = date1.getDate()-1;
            var day3 = date1.getDate();
            var month1  = date.getMonth();
            var month2 = date1.getMonth();
            var year1 = date.getFullYear();
            var year2 =  date.getFullYear();
            if(day1 == day2 || day1 < day2 || month1 < month2 || year1 < year2){
                    alert("select date as today or tomorrow or after");
                    document.getElementById('doo').value(year2+"-"+month2+"-"+day3); 
            }
            
        }

        debugger;
        function opTime(){
            var d = document.getElementById('optime').value;
            var d1 = d.toString().split(":");
            if(parseInt(d1[0]) < 8 && parseInt(d1[1]) > 00){
                alert("Appoinments opens only after 8:00");
                var d = new Date();
                var h = (d.getHours()<10?'0':'') + d.getHours();
                var m = (d.getMinutes()<10?'0':'') + d.getMinutes();
                document.getElementById('optime').value = h + ':' + m;
            }
            else if(parseInt(d1[0]) >= 13 && parseInt(d1[1]) > 0  && parseInt(d1[0]) <= 14 && parseInt(d1[1]) > 0){
                alert("luch time is between 1 to 2 select after 3");
                var d = new Date();
                var h = (d.getHours()<10?'0':'') + d.getHours();
                var m = (d.getMinutes()<10?'0':'') + d.getMinutes();
                document.getElementById('optime').value = h + ':' + m;
            }
            else if(parseInt(d1[0]) >= 21){
                alert("All appoinments closes at 9");
                var d = new Date();
                var h = (d.getHours()<10?'0':'') + d.getHours();
                var m = (d.getMinutes()<10?'0':'') + d.getMinutes();
                document.getElementById('optime').value(h + ':' + m);
            }
        }
    </script>

    <?php
        include "all.php";
            if($_SESSION["username"] == null){
                //header("Location: login.php");
                echo'<script>
                        if(alert("login please")){}
                        else    
                            window.location = "login.php";
                    </script>';
                
                
            }

    ?>
    <head>
        <title>Appoinment</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <form action="Appoinment.php" method="POST" id="login-form" class="login-form" autocomplete="off" role="main">
        <div>
            <label class="label-email">
                <input type="text" class="text" name="name" placeholder="<?php echo $_SESSION['name']; ?>" tabindex="1" disabled/>
                <span class="required">name</span>.
            </label>
        </div>
        <div>
            <label class="label-email">
                <input type="text" class="text" name="phno" placeholder="<?php echo $_SESSION['phno']; ?>" tabindex="1" disabled/>
                <span class="required">phno</span>
            </label>
        </div>
        <div>
            <label class="label-email">
                <input type="text" class="text" name="email" placeholder="<?php echo $_SESSION['email']; ?>" tabindex="1" disabled/>
                <span class="required">phno</span>
            </label>
        </div>
        <div>
            <label class="label-email">
                <input type="text" class="text" name="symptoms" tabindex="1" />
                <span class="required">symptoms</span>
            </label>
        </div>
        <div>
            <label class="label-email">
                <input type="date"  data-date="" data-date-format="YYYY-MM-DD" id="doo" name="doo" onchange="OpDate()" required class="text" name="symptoms" tabindex="1"/>
                <span class="required">select Date</span>
            </label>
        </div>
        <div>
            <label class="label-email">
                <input type="time"  onchange="opTime()" required class="text" name="optime" tabindex="1"/>
                <span class="required">select Date</span>
            </label>
        </div>
        <div>
            <label class="label-email">
                <span class="required">select Doctor</span>
                <select name="doctor">
                <?php
                    $query = "SELECT username from login where role='Doctor';";
                    $res = mysqli_query($con,$query);
                    if(mysqli_num_rows($res)>0){
                            while($rows = mysqli_fetch_assoc($res)){
                                echo "<option>".$rows["username"]. "</option>";
                            }
                    }
                ?>
            </select>
            </label>
        </div>
            <input type="submit" name="op" value="Submit">
        </form>
    </body>
</html>

<?php
    if (isset($_POST['op'])){
        $name = $_SESSION['name'];
        $phno = $_SESSION['phno'];
        $email = $_SESSION['email'];
        $symptoms = $_POST['symptoms'];
        $date = $_POST['doo'];
        $time = $_POST['optime'];
        $doctor = $_POST['doctor'];
        $role="Patient";
        $sql="Insert into appoinment (patientName,visitDate,visitTime,Symptoms,email,phno,doctorName,status) 
                        values('".$name."','".$date."','".$time."','".$symptoms."','".$email."',".$phno.",'".$doctor."','Pending');";
        if(mysqli_query($con, $sql)){
            echo'<script>
                    if(alert("Appoinment added Sucessfully")){}
                    else    
                        window.location = "Patient.php";
                </script>';
        }
        else{
            echo "Error: ".$sql."".mysqli_error($con);
        }
            
        
    }
?>