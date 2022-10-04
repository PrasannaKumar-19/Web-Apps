<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0 or strlen($_SESSION['dept'])==0 or strlen($_SESSION['sem'])==0 or strlen($_SESSION['bat'])==0) 
    {   
header('location:index.php');
}
else{



?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Enroll History</title>
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
                        <h1 class="page-head-line">Enroll History  </h1>
                    </div>
                </div>
      <div class="row" >
            
                <div class="col-md-12">
                   
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Enroll History
                        </div>
                      
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                            <table class="table" id="enrolltable">
                                    <thead>
                                    <?php
$sql=mysqli_query($bd, " select department as sdept, semester as ssem, batch as sbat from totalcredits where semester='".$_SESSION['sem']."' && department='".$_SESSION['dept']."' && batch='".$_SESSION['bat']."' ");
$cnt=1;
if($row=mysqli_fetch_array($sql))
{
?>							<tr>
								<th><?php echo htmlentities($row['sdept']);?></th>
                                <th><?php echo htmlentities($row['ssem']);?></th>
                                <th><?php echo htmlentities($row['sbat']);?></th>
							</tr>
<?php 
$cnt++;
} ?>
          
                                    <tr> 
                                            <th>#</th>
                                                <th>Student Reg No</th>
                                                <th>Student Name</th>
                                                <th>total credits</th>
                                                <th>course code</th>
                                                
                                             
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql=mysqli_query($bd, "select studentRegno as sregno,studentName as sname,creditsum as scred from totalcredits where department='".$_SESSION['dept']."' && semester='".$_SESSION['sem']."' && batch='".$_SESSION['bat']."' order by studentRegno");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo htmlentities($row['sregno']);?></td>
                                            <td><?php echo htmlentities($row['sname']);?></td>
                                            <td><?php echo htmlentities($row['scred']);?></td>
                                            <td><?php 
                                            
                                            
                                            $rql=mysqli_query($bd, "select course.courseCode as scode from courseenrolls join course on courseenrolls.course=course.id where courseenrolls.department='".$_SESSION['dept']."' && courseenrolls.semester='".$_SESSION['sem']."' && courseenrolls.batch='".$_SESSION['bat']."' && courseenrolls.studentregno='".$row['sregno']."' ");
                                            while($tab=mysqli_fetch_array($rql)){
                                            echo htmlentities($tab['scode']);
                                            echo(",");
                                        
                                            }      
                                            ?></td>
                                            
                 
                                        </tr>
<?php 
$cnt++;
continue;
} ?>

                                        
                                    </tbody>
                                </table>
                    
                <form>
					<button type="submit" id="downloadexcel" name="export" class=btn-btn-info" value="Export to Excel">Export to excel</button>
				   </form>
				    

                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>





        </div>
    </div>

    <script>
    document.getElementById('downloadexcel').addEventListener('click', function() {
           var table2excel = new Table2Excel();	
	   table2excel.export(document.querySelectorAll('#enrolltable'));
	});
</script>
   
  <?php include('includes/footer.php');?>
   
    <script src="assets/js/jquery-1.11.1.js"></script>
    <script src="assets/js/table2excel.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
<?php } ?>