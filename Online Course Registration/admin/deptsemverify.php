<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{

if(isset($_POST['submit']))
{
$sql=mysqli_query($bd, "SELECT * FROM  courseenrolls inner join course on course.id=courseenrolls.course where courseenrolls.department='".$_POST['department']."' && courseenrolls.semester='".$_POST['semester']."' && courseenrolls.batch='".$_POST['batch']."' && course.courseCode='".$_POST['course']."' ");
$num=mysqli_fetch_array($sql);
if($num>0)
{
$_SESSION['dept']=$_POST['department'];
$_SESSION['sem']=$_POST['semester'];
$_SESSION['bat']=$_POST['batch'];
$_SESSION['cour']=$_POST['course'];
header("location:enroll-history-ds.php");
}
else
{
$_SESSION['msg']="Error :Wrong dept or semester , batch,course. Please Enter a correctly !!";
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
    <title>dept - sem - batch</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
<?php include('includes/header.php');?>
    
<?php if($_SESSION['alogin']!="")
{
 include('includes/menubar.php');
}
 ?>
   
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Dept-Sem-batch selection</h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          choose dept-sem-batch
                        </div>
<font color="red" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="deptsemverify" method="post">
   <div class="form-group">
    <label for="department">Department</label>
    <input type="text" class="form-control" id="department" name="department" placeholder=" enter department" required />
  </div>
 
	<div class="form-group">
    <label for="semester">Semester</label>
    <input type="text" class="form-control" id="semester" name="semester" placeholder="enter semester" required />
  </div>

  <div class="form-group">
    <label for="batch">Batch</label>
    <input type="text" class="form-control" id="batch" name="batch" placeholder="enter batch year" required />
  </div>

  <div class="form-group">
    <label for="course">Course code</label>
    <input type="text" class="form-control" id="course" name="course" placeholder="enter course code" required />
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
<?php } ?>
