<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{
date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );
}
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title> Course Type Select</title>
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
                        <h1 class="page-head-line">Select type of the course</h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          Course Type Selection
                        </div>


                        <div class="panel-body">
                       
<button onclick="window.location.href= 'corecourse.php';">Cumpulsory Core Courses</button>	</br>	</br>	
	
<button onclick="window.location.href= 'PEcourse.php';">Programme Elective Courses</button> </br>  </br>

<button onclick="window.location.href= 'enroll-history.php';">One Credit Elective Courses</button>  </br> </br>

<button onclick="window.location.href= 'creditcheck.php';">Open Elective Courses</button>  </br> </br>

<button onclick="window.location.href= 'creditcheckreg.php';">Non-CGPA Courses</button>  </br> </br>



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
