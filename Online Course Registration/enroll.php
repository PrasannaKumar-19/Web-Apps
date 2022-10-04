<?php
session_start();
include('includes/config.php');
  $rst=mysqli_query($bd, "select elective from semester where semester='".$_SESSION['semes']."' ");
  $row=mysqli_fetch_assoc($rst);
  $cr=$row["elective"];
if (strlen($_SESSION['login']) == 0 or strlen($_SESSION['depart']) == 0 or strlen($_SESSION['semes']) == 0 or strlen($_SESSION['reg']) == 0) {
  header('location:index.php');
} else {
  date_default_timezone_set('Asia/Kolkata'); // change according timezone
  $currentTime = date('d-m-Y h:i:s A', time());
  if (isset($_POST['submit'])) {
    $studentregno = $_POST['studentregno'];
    $studentname = $_POST['studentname'];
    $dept = $_POST['department'];
    $sem = $_POST['sem'];
    $batch = $_POST['batch'];
    $e = $_POST['elective'];
    $c = $_POST['course'];
    /*foreach($c as $a){
      $_SESSION['msg'] .= $a;
    }*/
    $sql = mysqli_query($bd, "SELECT creditsum from totalcredits where studentname='" . $_POST['studentname'] . "' && studentRegno='" . $_POST['studentregno'] . "' &&  semester='" . $_POST['sem'] . "' && department='" . $_POST['department'] . "' && batch='" . $_POST['batch'] . "'");
    if (mysqli_num_rows($sql) > 0) {
      $num = mysqli_fetch_assoc($sql);
      if ($num["creditsum"] < 30) {
        foreach($c as $a){
          $course = $a;
          $ref = mysqli_query($bd, "SELECT count(*) as allcount FROM courseenrolls where studentName='" . $_POST['studentname'] . "' && semester='" . $_POST['sem'] . "' && course='" . $a . "' && department='" . $_POST['department'] . "' && studentRegno='" . $_POST['studentregno'] . "' && batch='" . $_POST['batch'] . "' ");
          $col = mysqli_fetch_array($ref);
          $allcount = $col['allcount'];
          if ($allcount == 0) {
            $tab = mysqli_query($bd, "SELECT credit from course where id='" . $a . "'");
            $row = mysqli_fetch_assoc($tab);
            $cdt = $row["credit"];
            $res = mysqli_query($bd, "UPDATE totalcredits SET creditsum=creditsum+$cdt where studentname='" . $_POST['studentname'] . "' &&  semester='" . $_POST['sem'] . "' && batch='" . $_POST['batch'] . "' && studentRegno='" . $_POST['studentregno'] . "' && department='" . $_POST['department'] . "' ");
            if ($res) {
              
              $ret = mysqli_query($bd, "insert into courseenrolls(studentRegno,studentname,department,course,semester,batch) values('$studentregno','$studentname','$dept','$course','$sem','$batch')");
              if ($ret) {
                $_SESSION['msg'] .= $a . "Enroll Successfully !! ";
              } else {
                $_SESSION['msg'] = "Error : Not Enroll";
              }
            } else {
              $_SESSION['msg'] = "Error in credit updation process";
            }
          }
        }
        foreach($e as $el){
          $cc = mysqli_fetch_assoc(mysqli_query($bd,"select id from course where courseName= '".$el."' "));
          $res= isset($cc['id']);
          $cc1 = mysqli_fetch_assoc(mysqli_query($bd,"SELECT credit from course where id='" . $res . "'"));
          $cred = isset($cc1['credit']); 
          $ret = mysqli_query($bd, "insert into courseenrolls(studentRegno,studentname,department,course,semester,batch) values('$studentregno','$studentname','$dept','$el','$sem','$batch')");
          $_SESSION['msg'] .= $el . "Enroll Successfully !! ";
          if($ret){
            $o = mysqli_query($bd, "UPDATE totalcredits SET creditsum=creditsum+$cred where studentname='" . $_POST['studentname'] . "' &&  semester='" . $_POST['sem'] . "' && batch='" . $_POST['batch'] . "' && studentRegno='" . $_POST['studentregno'] . "' && department='" . $_POST['department'] . "' ");
          }

        }
      } else {
        $_SESSION['msg'] = "You have selected course for more than 30 credits. Please register within 30 credits";
      }
    } else {
      $ref = mysqli_query($bd, "SELECT count(*) as allcount FROM courseenrolls where studentname='" . $_POST['studentname'] . "' && semester='" . $_POST['sem'] . "' && course='" . $_POST['course'] . "' && department='" . $_POST['department'] . "' && studentRegno='" . $_POST['studentregno'] . "' && batch='" . $_POST['batch'] . "' ");
      $col = mysqli_fetch_array($ref);
      $allcount = $col['allcount'];
      if ($allcount == 0) {
          $tab = mysqli_query($bd, "SELECT credit from course where id='" . $a . "'");
          $row = mysqli_fetch_assoc($tab);
          $cr = $row["credit"];
          $studentregno = $_POST['studentregno'];
          $studentname = $_POST['studentname'];
          $dept = $_POST['department'];
          $course = $a;
          $sem = $_POST['sem'];
          $batch = $_POST['batch'];
          $res = mysqli_query($bd, "INSERT INTO totalcredits(creditsum,studentname,semester,batch,studentRegno,department) values($cr,'$studentname','$sem','$batch','$studentregno','$dept')");
          if ($res) {

            $ret = mysqli_query($bd, "insert into courseenrolls(studentRegno,studentname,department,course,semester,batch) values('$studentregno','$studentname','$dept','$course','$sem','$batch')");
            if ($ret) {
              $_SESSION['msg'] .= $a."Enroll Successfully !!";
            } else {
              $_SESSION['msg'] = "Error : Not Enroll";
            }
          } else {
            $_SESSION['msg'] = "Error in credit insertion process";
          }
      }
    }
  }

?>

  <!DOCTYPE html>
 
  <html xmlns="http://www.w3.org/1999/xhtml">
  <?php include('includes/footer.php'); ?>
    <script src="assets/js/jquery-1.11.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script>
      function courseAvailability(value) {
        $("#loaderIcon").show();
        jQuery.ajax({
          url: "check_availability.php",
          data: 'cid=' + value,
          type: "POST",
          success: function(data) {
            $("#course-availability-status1").html(data);
            $("#loaderIcon").hide();
          },
          error: function() {}
        });
      }
    </script>
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
    <?php include('includes/header.php'); ?>
    <!-- LOGO HEADER END-->
    <?php if ($_SESSION['login'] != "") {
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
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                Course Enroll
              </div>
              <font color="green" align="center"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></font>
              <?php $sql = mysqli_query($bd, "select * from students where StudentRegno='" . $_SESSION['login'] . "'");
              $cnt = 1;
              while ($row = mysqli_fetch_array($sql)) { ?>

                <div class="panel-body">
                  <form name="dept" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="studentname">Student Name </label>
                      <input type="text" class="form-control" id="studentname" name="studentname" value="<?php echo htmlentities($row['studentName']); ?>" readonly />
                    </div>

                    <div class="form-group">
                      <label for="studentregno">Student Reg No </label>
                      <input type="text" class="form-control" id="studentregno" name="studentregno" value="<?php echo htmlentities($row['StudentRegno']); ?>" placeholder="Student Reg no" readonly />

                    </div>

                    <div class="form-group">
                      <label for="batch">Batch </label>
                      <input type="text" class="form-control" id="batch" name="batch" readonly value="<?php echo htmlentities($row['batch']); ?>" required />
                    </div>


                    <div class="form-group">
                      <label for="Pincode">Student Photo </label>
                      <?php if ($row['studentPhoto'] == "") { ?>
                        <img src="studentphoto/noimage.png" width="200" height="200"><?php } else { ?>
                        <img src="studentphoto/<?php echo htmlentities($row['studentPhoto']); ?>" width="200" height="200">
                      <?php } ?>
                    </div>
                  <?php } ?>

                  <?php $sql = mysqli_query($bd, "select department from department where department='" . $_SESSION['depart'] . "'");
                  $cnt = 1;
                  while ($row = mysqli_fetch_array($sql)) {
                  ?>
                    <div class="form-group">
                      <label for="Department">Department </label>
                      <input type="text" class="form-control" name="department" readonly value="<?php echo htmlentities($row['department']); ?>" />
                    </div>

                  <?php } ?>


                  <?php $sql = mysqli_query($bd, "select semester from semester where semester='" . $_SESSION['semes'] . "'");
                  $cnt = 1;
                  while ($row = mysqli_fetch_array($sql)) {
                  ?>

                    <div class="form-group">
                      <label for="Semester">Semester </label>
                      <input type="text" class="form-control" name="sem" readonly value="<?php echo htmlentities($row['semester']); ?>" />
                    </div>

                  <?php } ?>


                  <div class="form-group">
                    <label for="Course">Course </label>
                    <br>
                    <select class="form-select" multiple aria-label="multiple select example"  name="course[]" id="course[]" onchange="courseAvailability(this.value)" required="required">
                      
                      <?php
                      $sql = mysqli_query($bd, "select * from course where type='Core' and department='" . $_SESSION['depart'] . "' and semester='" . $_SESSION['semes'] . "' and regulation='" . $_SESSION['reg'] . "'");
                      while ($row = mysqli_fetch_array($sql)) {
                      ?>
                        <option value="<?php echo $row['id']; ?>" selected><?php echo $row['courseName']; ?></option>
                      <?php } ?>
                    </select>
                    <span id="course-availability-status1" style="font-size:12px;">
                  </div>

                  <div class="form-group">
                  <label for="Course">Elective </label>
                  <br>
                  <?php
                    for($i=1;$i<=$cr;$i++){
                      ?>
                            <div class="form-group">
                                <label for="Course">Course  </label>
                                <select class="form-select" aria-label="Default select example" name="elective[]" id="elective[]" onchange="courseAvailability(this.value)"  required="required">
                              <option value="">Select Elective course</option>   
                              <?php 
                            $sql=mysqli_query($bd ,"select * from course where type= 'Elective".$i."' and department='".$_SESSION['depart']."' and semester='".$_SESSION['semes']."' and regulation='".$_SESSION['reg']."' ");
                            while($row=mysqli_fetch_array($sql))
                            {
                            ?>
                            <option value="<?php echo htmlentities($row['id']);?>" ><?php echo htmlentities($row['courseName']);?></option>
                            <?php } ?>
                                </select> 
                              </div>
                    <?php }?>
                    <span id="course-availability-status1" style="font-size:12px;">
                  </div>



                  <button type="submit" name="submit" id="submit" class="btn btn-default">Enroll</button>
                  </form>
                </div>
            </div>
          </div>

        </div>

      </div>





    </div>
    </div>

    

  </body>

  </html>
<?php } ?>