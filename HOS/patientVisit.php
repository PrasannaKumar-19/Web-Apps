<!Doctype html>
<html>
    <head>
            <title>Visit</title>
            <link rel="stylesheet" type="text/css" href="style.css" id="login-form" class="login-form" autocomplete="off" role="main">
    </head>
    </body>
        <form action="patientVisit.php" method="POST">
            <div>
            <label class="label-email">
            <span class="required">PatientName</span>
            <select name="name">
                <?php
                    include "all.php";
                    $todayDate = strval(date('Y-m-d',strtotime("+1 days")));
                    $query = "SELECT patientName from appoinment where doctorName='".$_SESSION["username"]."' and visitDate='".$todayDate."' and status='Pending';";
                    $res = mysqli_query($con,$query);
                    if(mysqli_num_rows($res)>0){
                            while($rows = mysqli_fetch_assoc($res)){
                                echo "<option>".$rows["patientName"]."</option>";
                            }
                    }
                ?>
            </select>
                </label>
            </div>
            <div>
                <label class="label-email">
                    <input type="text" class="text" name="symptoms" placeholder="Symptoms" tabindex="1" required />
                    <span class="required">Sympotoms</span>
                </label>
            </div>
            <div>
                <label class="label-email">
                    <span class="required">Medicine</span>
                    <select name="medicine">
                        <?php
                            $query = "SELECT medName from tablets where medCount > 10;";
                            $res = mysqli_query($con,$query);
                            if(mysqli_num_rows($res)>0){
                                    while($rows = mysqli_fetch_assoc($res)){
                                        echo "<option>".$rows["medName"]."</option>";
                                    }
                            }
                            else{
                                echo"<option>nothing available</option>";
                            }
                        ?>
                    </select>
                </label>

            </div>
            <div>
            
                <label class="label-email">
                    
                    <table>
                    <tr>
                        <td>
                        <label class="container">MAF
                            <input type="checkbox" name="color[]" value="MAF">
                            <span class="checkmark"></span>
                        </label>
                            </td>
                        <td>
                        <label class="container">MBF
                            <input type="checkbox" name="color[]" value="MBF">
                            <span class="checkmark"></span>
                        </label>
                            </td>
                        <td>
                        <label class="container">AAF
                            <input type="checkbox" name="color[]" value="AAF">
                            <span class="checkmark"></span>
                        </label>
                            </td>
                    </tr>
                    <tr>
                        <td>
                    <label class="container">ABF
                        <input type="checkbox" name="color[]" value="ABF">
                        <span class="checkmark"></span>
                    </label>
                        </td>
                        <td>
                    <label class="container">NAF
                        <input type="checkbox" name="color[]" value="NAF">
                        <span class="checkmark"></span>
                    </label>
                        </td>
                        <td>
                    <label class="container">NBF
                        <input type="checkbox" name="color[]" value="NBF">
                        <span class="checkmark"></span>
                    </label>
                        </td>
                        </tr>
                        </table>
                </label>
            </div>
            <div>
                <label class="label-email">
                    <input type="text" class="text" name="count" placeholder="Count" tabindex="1" required />
                    <span class="required">Medicine Count</span>
                </label>
            </div>
            <div>
                <label class="label-email">
                    <input type="text" class="text" name="diet" placeholder="diet" tabindex="1" required />
                    <span class="required">Diet</span>
                </label>
            </div>
            <div>
                <label class="label-email">
                    <input type="text" class="text" name="remarks" placeholder="Remarks" tabindex="1" required >

                    <span class="required">Remarks</span>
                </label>
            </div>
            <div>
                <label class="label-email">
                    <span class="required" tabindex="1">Status</span>
                    <select name="status">
                        <option>Pending</option>
                        <option>Completed</option>
                    </select>
                </label>
            </div>
            <input type="submit" name="submit">
        </form>
    </body>
</html>

<?php
if(isset($_POST['submit'])){
    $pName = $_POST['name'];
    $symptoms = $_POST['symptoms'];
    $medicine = $_POST['medicine'];
    $take = $_POST['color'];
    $take1 = "|";
    foreach($take as $med){
        $take1 .= $med."|";
    }
    $count = $_POST['count'];
    $diet = $_POST['diet'];
    $remarks = $_POST['remarks'];
    $status = $_POST['status'];
    
    $app = "select id from appoinment where patientName = '".$pName."' and visitDate = '".$todayDate."' limit 1;";
    $res = mysqli_query($con,$app);
    $row = mysqli_fetch_assoc($res);
    $id = (int)$row["id"];
    
    $sql = "Insert into doctorvisit(doctorName,patientName,Symptoms,Medicine,medCount,inTake,remarks,diet,status,appoinmentid) values('".$_SESSION['username']."','".$pName."','".$symptoms."','".$medicine."',".$count.",'".$take1."','".$remarks."','".$diet."','".$status."',".$row["id"].");";
    if(mysqli_query($con,$sql)){
        $select = "select medFee from tablets where medName= '".$medicine."';";
        $res2 = mysqli_query($con,$select);
        $row2 = mysqli_fetch_assoc($res2);
        $id2 = (int)$row2["medFee"];
        $rate = (int)$id2*(int)$count;
        $s = " x ";
        $r = "select id from doctorvisit where patientName='".$pName."' and appoinmentid=".$row["id"]." ;";
        $res1 = mysqli_query($con,$r);
        $row1 = mysqli_fetch_assoc($res1);
        $rate1 = (int)$id2*(int)$count;
        $update = "update doctorvisit set fees = 500+(".$rate1.") where appoinmentid= ".$row["id"]."; ";
        $update .= "update tablets set medcount = medcount-".$count." where medName= '".$medicine."'; ";
        $update .= "update appoinment set status = '".$status."' where id= ".$id."; ";
        $update .= "Insert into bill(name,serviceCharge,medFee,items,visitId,total) values('".$pName."','500',".$rate1.",'".$medicine.$s.$count."',".$row1["id"].",500+".$rate1.")";
        mysqli_multi_query($con,$update);
    }
    else{
        echo'<script>
                            if(alert("Error")){}
                            else    
                                window.location = "patientVisit.php";
                        </script>';
    }

    echo'<script>
                            if(alert("Visit Completed")){}
                            else    
                                window.location = "Doctor.php";
                        </script>';
}

?>