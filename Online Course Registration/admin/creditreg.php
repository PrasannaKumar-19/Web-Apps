<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0 or strlen($_SESSION['regno'])==0) 
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
    <title>credit earned</title>
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
                        <h1 class="page-head-line">Credits Earned by the Students </h1>
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
$sql=mysqli_query($bd, "select studentRegno as sreg,studentname as sname from totalcredits where studentRegno='".$_SESSION['regno']."' ");
$cnt=1;
if($col=mysqli_fetch_array($sql))
{
?>							<tr>
								<th>student Reg No:     <?php echo htmlentities($col['sreg']);?></th>
                                <th>Student name:       <?php echo htmlentities($col['sname']);?></th>
							</tr>
<?php 
$cnt++;
} ?>
                                        <tr> 
                                            <th>#</th>
                        
                                                <th>Semester</th>
                                                <th>Credits Earned</th>
                                                <th>Department</th>
                                                <th>Batch</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql=mysqli_query($bd, "select semester as ssem, creditsum as scredit, batch as sbatch, department as sdept from totalcredits where studentRegno='".$_SESSION['regno']."' ");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>

                                            <td><?php echo htmlentities($row['ssem']);?></td>
                                            <td><?php echo htmlentities($row['scredit']);?></td>
                                            <td><?php echo htmlentities($row['sdept']);?></td>
                                            <td><?php echo htmlentities($row['sbatch']);?></td>
                                        </tr>
<?php 
$cnt++;
} ?>

<?php
$sql=mysqli_query($bd,"select SUM(creditsum) as scred from totalcredits where studentRegno='".$_SESSION['regno']."'");
$tab=mysqli_fetch_array($sql);
if($tab){
?>
                                        <tr>
                                            <td>total credits earned all semesters = <?php echo htmlentities($tab['scred']);?> </td>
                                        </tr>
<?php
}    
?>                                 
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