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

  $ref=mysqli_query($bd, "SELECT count(*) as allcount FROM pecourse where courseName='".$_POST['coursename']."' && courseCode='".$_POST['coursecode']."' && semester='".$_POST['semester']."' && department='".$_POST['department']."' && regulation='".$_POST['regulation']."' && credit='".$_POST['credit']."' && noofelectives='".$_POST['noofelectives']."' && batch='".$_POST['batch']."' && electivepos='".$_POST['electivepos']."' ");
  $col=mysqli_fetch_array($ref);
  $allcount=$col['allcount'];
  if($allcount==0){
    $coursecode=$_POST['coursecode'];
    $coursename=$_POST['coursename'];
    $department=$_POST['department'];
    $semester=$_POST['semester'];
    $noofelectives=$_POST['noofelectives'];
    $electivepos=$_POST['electivepos'];
    $credit=$_POST['credit'];
    $seatlimit=$_POST['seatlimit'];
    $batch=$_POST['batch'];
    $regulation=$_POST['regulation'];
    $ret=mysqli_query($bd, "insert into pecourse(courseCode,courseName,department,semester,noofelectives,electivepos,credit,noofSeats,regulation,batch) values('$coursecode','$coursename','$department','$semester','$noofelectives','$electivepos','$credit','$seatlimit','$regulation','$batch')");
    if($ret)
    {
    $_SESSION['msg']="Course Created Successfully !!";
    }
    else
    {
      $_SESSION['msg']="Error : Course not created";
    }
  }
  else{
    $_SESSION['msg']="This course was already created. please enter another course.";
  }
}
if(isset($_GET['del']))
      {
              mysqli_query($bd, "delete from pecourse where id = '".$_GET['id']."'");
                  $_SESSION['delmsg']="Course deleted !!";
      }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin | PECourse</title>
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
                        <h1 class="page-head-line">Course  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Course 
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="dept" method="post">
   <div class="form-group">
    <label for="coursecode">Course Code  </label>
    <input type="text" class="form-control" id="coursecode" name="coursecode" placeholder="Course Code" required />
  </div>

 <div class="form-group">
    <label for="coursename">Course Name  </label>
    <input type="text" class="form-control" id="coursename" name="coursename" placeholder="Course Name" required />
  </div>

<div class="form-group">
    <label for="department">Department Name  </label>
    <input type="text" class="form-control" id="department" name="department" placeholder="Department Name" required />
  </div>

<div class="form-group">
    <label for="semester">Semester  </label>
    <input type="text" class="form-control" id="semester" name="semester" placeholder="Semester" required />
  </div>

  <div class="form-group">
    <label for="noofelectives">No Of Electives  </label>
    <input type="number" class="form-control" id="noofelectives" name="noofelectives" placeholder="noofelectives" required />
  </div>

  <div class="form-group">
    <label for="electivepos">Elective Number  </label>
    <input type="text" class="form-control" id="electivepos" name="electivepos" placeholder="elective number" required />
  </div>

  <div class="form-group">
    <label for="credit">Credit  </label>
    <input type="number" class="form-control" id="credit" name="credit" placeholder="Credit Value" required />
  </div>

<div class="form-group">
    <label for="seatlimit">Seat limit  </label>
    <input type="number" class="form-control" id="seatlimit" name="seatlimit" placeholder="Seat limit" required />
  </div>   

  <div class="form-group">
    <label for="regulation">Regulation  </label>
    <input type="text" class="form-control" id="regulation" name="regulation" placeholder="regulation" required />
  </div>

  <div class="form-group">
    <label for="batch">Batch Year  </label>
    <input type="text" class="form-control" id="batch" name="batch" placeholder="batch" required />
  </div>

 <button type="submit" name="submit" class="btn btn-default">Submit</button>
</form>
                            </div>
                            </div>
                    </div>
                  
                </div>
                <font color="red" align="center"><?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?></font>
                <div class="col-md-12">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Manage Programme Elective Course
                        </div>
                       
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Course Code</th>
                                            <th>Course Name </th>
                                            <th>Department Name</th>
                                            <th>Semester</th>
                                            <th>No of Electives</th>
                                            <th>Elective Number</th>
                                            <th>Credit</th>
                                            <th>Seat limit</th>
                                            <th>Regulation</th>
                                            <th>batch</th>
                                            <th>Creation Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql=mysqli_query($bd, "select * from pecourse");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo htmlentities($row['courseCode']);?></td>
                                            <td><?php echo htmlentities($row['courseName']);?></td>
                                            <td><?php echo htmlentities($row['department']);?></td>
                                            <td><?php echo htmlentities($row['semester']);?></td>
                                            <td><?php echo htmlentities($row['noofelectives']);?></td>
                                            <td><?php echo htmlentities($row['electivepos']);?></td>
                                            <td><?php echo htmlentities($row['credit']);?></td>
                                            <td><?php echo htmlentities($row['noofSeats']);?></td>
                                            <td><?php echo htmlentities($row['regulation']);?></td>
                                            <td><?php echo htmlentities($row['batch']);?></td>
                                            <td><?php echo htmlentities($row['creationDate']);?></td>
                                            <td>
                                            <a href="PEedit-course.php?id=<?php echo $row['id']?>">
<button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button> </a>                                        
  <a href="PEC.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')">
                                            <button class="btn btn-danger">Delete</button>
</a>
                                            </td>
                                        </tr>
<?php 
$cnt++;
} ?>

                                        
                                    </tbody>
                                </table>
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
</body>
</html>
<?php } ?>
