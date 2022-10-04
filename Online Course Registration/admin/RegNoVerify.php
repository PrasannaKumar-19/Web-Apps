<?php
session_start();
error_reporting(1);
include("includes/config.php");
if(isset($_POST['submit']))
{
    $regno=$_POST['regno'];
$query=mysqli_query($bd, "SELECT * FROM students WHERE StudentRegno='$regno'");
if(mysqli_num_rows($query)>0)
{
$num=mysqli_fetch_array($query);
$extra="enroll-history-reg.php";//
$_SESSION['login']=$_POST['regno'];
$_SESSION['id']=$num['studentRegno'];
$_SESSION['sname']=$num['studentName'];
$uip=$_SERVER['REMOTE_ADDR'];
$status=1;
$log=mysqli_query($bd, "insert into enrollhistorycheck(studentRegno,userip,status) values('".$_SESSION['login']."','$uip','$status')");
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
$_SESSION['errmsg']="Invalid Reg no.";
$extra="RegNoVerify.php";
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
}
?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>student verification</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
<?php include('includes/header.php');?>
    
<?php include('includes/menubar.php');?>
   
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Student Reg no. Verification</h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          Reg no. Verification
                        </div>
<font color="red" align="center"><?php echo htmlentities($_SESSION['errmsg']);?><?php echo htmlentities($_SESSION['errmsg']="");?></font>


                        <div class="panel-body">
                       <form name="regnoverify" method="post">
   <div class="form-group">
    <label>Enter Student Reg no.</label>
    <input type="number" class="form-control" name="regno" placeholder="reg no" required />
  </div>
 
  
  <button type="submit" name="submit" class="btn btn-default">Verify</button>
                           <hr />
   



</form>
                            </div>
                            </div>
                    </div>
                  
                </div>
        </div>
    </div>
    
  <?php include('includes/footer.php');?>
   
    <script src="assets/js/jquery-1.11.1.js"></script>

    <script src="assets/js/bootstrap.js"></script>
</body>
</html>