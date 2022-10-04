<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['login'])==0 or strlen($_SESSION['depart'])==0 or strlen($_SESSION['semes'])==0 or strlen($_SESSION['reg'])==0 or strlen($_SESSION['bat'])==0)
    {   
header('location:index.php');
}
else{

  if(isset($_POST['submit']))
  {
    $sql=mysqli_query($bd, "SELECT creditsum from totalcredits where studentname='".$_POST['studentname']."' && studentRegno='".$_POST['studentregno']."' &&  semester='".$_POST['sem']."' && department='".$_POST['department']."' && batch='".$_POST['batch']."'");
    if(mysqli_num_rows($sql)>0){
        $num=mysqli_fetch_assoc($sql);
        if($num["creditsum"]<30){
          $rst=mysqli_query($bd, "select noofelectives from pecourse where semester='".$_SESSION['semes']."' and department='".$_SESSION['depart']."' and batch='".$_SESSION['bat']."' and regulation='".$_SESSION['reg']."'");
          $row=mysqli_fetch_assoc($rst);
          $cr=$row["noofelectives"];
          for($i=1;$i<=$cr;$i++){
          $ref=mysqli_query($bd, "SELECT count(*) as allcount FROM pecenroll where studentname='".$_POST['studentname']."' && semester='".$_POST['sem']."' && course='".$_POST['course']." $i' && department='".$_POST['department']."' && studentRegno='".$_POST['studentregno']."' && batch='".$_POST['batch']."' ");
          $col=mysqli_fetch_array($ref);
          $allcount=$col['allcount'];
          if($allcount==0){
              $tab=mysqli_query($bd, "SELECT credit from pecourse where id='".$_POST['course']." $i' ");
              $row=mysqli_fetch_assoc($tab);
              $cdt=$row["credit"];
              $res=mysqli_query($bd,"UPDATE totalcredits SET creditsum=creditsum+$cdt where studentname='".$_POST['studentname']."' &&  semester='".$_POST['sem']."' && batch='".$_POST['batch']."' && studentRegno='".$_POST['studentregno']."' && department='".$_POST['department']."' ");
              if($res){
                $studentregno=$_POST['studentregno'];
              $studentname=$_POST['studentname'];
              $dept=$_POST['department'];
              $course=$_POST['course'.$i];
              $sem=$_POST['sem'];
              $batch=$_POST['batch'];
                  
                  $ret=mysqli_query($bd, "insert into pecenroll(studentRegno,studentName,department,course,semester,batch) values('$studentregno','$studentname','$dept','$course','$sem','$batch')");
                  if($ret)
                  {
                    $_SESSION['msg']="Enroll Successfully !!";
                  }
                  else
                  {
                    $_SESSION['msg']="Error : Not Enroll";
                  }
              }
              else{
                $_SESSION['msg']="Error in credit updation process";
              }
        
            }
          }
        }
        else{
          $_SESSION['msg']="You have selected course for more than 30 credits. Please register within 30 credits";
        }
    }
    else{
      $rst=mysqli_query($bd, "select noofelectives from pecourse where semester='".$_SESSION['semes']."' and department='".$_SESSION['depart']."' and batch='".$_SESSION['bat']."' and regulation='".$_SESSION['reg']."'");
      $row=mysqli_fetch_assoc($rst);
      $vr=$row["noofelectives"];
      for($i=1;$i<=$vr;$i++){
          $ref=mysqli_query($bd, "SELECT count(*) as allcount FROM pecenroll where studentname='".$_POST['studentname']."' && semester='".$_POST['sem']."' && course='".$_POST['course']." $i' && department='".$_POST['department']."' && studentRegno='".$_POST['studentregno']."' && batch='".$_POST['batch']."' ");
          $col=mysqli_fetch_array($ref);
          $allcount=$col['allcount'];
          if($allcount==0){
              $tab=mysqli_query($bd, "SELECT credit from pecourse where id='".$_POST['course']." $i' ");
              $row=mysqli_fetch_assoc($tab);
              $cr=$row["credit"];
              $studentregno=$_POST['studentregno'];
                $studentname=$_POST['studentname'];
                $dept=$_POST['department'];
                $course=$_POST['course'.$i];
                $sem=$_POST['sem'];
                $batch=$_POST['batch'];
              $res=mysqli_query($bd,"INSERT INTO totalcredits(creditsum,studentname,semester,batch,studentRegno,department) values($cr,'$studentname','$sem','$batch','$studentregno','$dept')");
              if($res){
              
                  $ret=mysqli_query($bd, "insert into pecenroll(studentRegno,studentname,department,course,semester,batch) values('$studentregno','$studentname','$dept','$course','$sem','$batch')");
                  if($ret)
                  {
                    $_SESSION['msg']="Enroll Successfully !!";
                  }
                  else
                  {
                    $_SESSION['msg']="Error : Not Enroll";
                  }
                }
                else{
                    $_SESSION['msg']="Error in credit insertion process";
                }
              }
      }  
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
    <title>Course Enroll</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
<?php include('includes/header.php');?>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['login']!="")
{
 include('includes/menubar.php');
}
 ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Course Enroll </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          Course Enroll
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>
<?php $sql=mysqli_query($bd, "select * from students where StudentRegno='".$_SESSION['login']."'");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{ ?>

                        <div class="panel-body">
                       <form name="dept" method="post" enctype="multipart/form-data">
   <div class="form-group">
    <label for="studentname">Student Name  </label>
    <input type="text" class="form-control" id="studentname" name="studentname" value="<?php echo htmlentities($row['studentName']);?>" readonly />
  </div>

 <div class="form-group">
    <label for="studentregno">Student Reg No   </label>
    <input type="text" class="form-control" id="studentregno" name="studentregno" value="<?php echo htmlentities($row['StudentRegno']);?>"  placeholder="Student Reg no" readonly />
    
  </div>  

 <div class="form-group">
    <label for="batch">Batch  </label>
    <input type="text" class="form-control" id="batch" name="batch" readonly value="<?php echo htmlentities($row['batch']);?>" required />
  </div> 


<div class="form-group">
    <label for="Pincode">Student Photo  </label>
   <?php if($row['studentPhoto']==""){ ?>
   <img src="studentphoto/noimage.png" width="200" height="200"><?php } else {?>
   <img src="studentphoto/<?php echo htmlentities($row['studentPhoto']);?>" width="200" height="200">
   <?php } ?>
  </div>
 <?php } ?>

<?php $sql=mysqli_query($bd, "select department from department where department='".$_SESSION['depart']."'");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{ 
?>
<div class="form-group">
    <label for="Department">Department  </label>
    <input type="text" class="form-control" name="department" readonly value="<?php echo htmlentities($row['department']);?>" />	  
   </div>

<?php } ?>


<?php $sql=mysqli_query($bd, "select semester from semester where semester='".$_SESSION['semes']."'");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{ 
?>

<div class="form-group">
    <label for="Semester">Semester  </label>
<input type="text" class="form-control" name="sem" readonly value="<?php echo htmlentities($row['semester']);?>" />
  </div>  

 <?php } ?>


     
 <?php
 $rst=mysqli_query($bd, "select noofelectives from pecourse where semester='".$_SESSION['semes']."' and department='".$_SESSION['depart']."' and batch='".$_SESSION['bat']."' and regulation='".$_SESSION['reg']."'");
 $row=mysqli_fetch_assoc($rst);
 $cr=$row["noofelectives"];
 
 for($i=1;$i<=$cr;$i++){
  ?>
        <div class="form-group">
            <label for="Course">Course  </label>
            <select class="form-control" name="course<?php $i?>" id="course" onBlur="courseAvailability()" required="required">
          <option value="">Select Elective course</option>   
          <?php 
        $sql=mysqli_query($bd ,"select * from pecourse where department='".$_SESSION['depart']."' and semester='".$_SESSION['semes']."' and regulation='".$_SESSION['reg']."' and batch='".$_SESSION['bat']."' and electivepos=$i");
        while($row=mysqli_fetch_array($sql))
        {
        ?>
        <option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['courseName']);?></option>
        <?php } ?>
            </select> 
            <span id="course-availability-status1" style="font-size:12px;">
          </div>
<?php }?>


 <button type="submit" name="submit" id="submit" class="btn btn-default">Enroll</button>
</form>
                            </div>
                            </div>
                    </div>
                  
                </div>

            </div>





        </div>
    </div>
    
  <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.11.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script>
function courseAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "pecheck_availability.php",
data:'cid='+$("#course").val(),
type: "POST",
success:function(data){
$("#course-availability-status1").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>

</body>
</html>
<?php } ?>
