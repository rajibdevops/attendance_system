<?php include("auth.php");  
//https://adnan-tech.com/google-maps-in-php-without-api-key-by-coordinates-by-address/
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
      <title>:Basmah Attendance System:</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>
<?php require('db.php');
//date_default_timezone_set('America/Los_Angeles');
date_default_timezone_set("America/New_York");
?>
<!--<div class="form">-->
 <?php $username=$_SESSION['username']; 

    $query = "SELECT * FROM `users` WHERE username='$username'";
    $result = mysqli_query($con,$query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($result);  
    $empID=         $row["emp_id"];
    $queryEmp= "SELECT * FROM employee INNER JOIN organization_category ON employee.org_category_id=organization_category.category_id INNER JOIN workstation ON employee.workstation_id=workstation.workstation_id INNER JOIN designation ON employee.designation_id=designation.designation_id WHERE employee.employee_code='$empID'";

    $Empresult = mysqli_query($con,$queryEmp) or die(mysqli_error($con));
    $rowEmp = mysqli_fetch_assoc($Empresult);  
    $empName= $rowEmp["employee_name"];
    $OrgCategory= $rowEmp["category"];
    $OrgCategoryID= $rowEmp["category_id"];

    $workstation=$rowEmp["workstation"];
    $workstationID=$rowEmp["workstation_id"];
    $designation=$rowEmp["designation"];
    $designationID=$rowEmp["designation_id"];
 


  if (isset($_REQUEST['org_category'])){
        $emp_id= $_REQUEST['emp_id']; // removes backslashes
        $org_category = $_REQUEST['OrgCategoryID'];
        $workstation_id = $_REQUEST['workstationID'];
        $emp_designation_id = $_REQUEST['designationID'];
      //  $addingFiveMinutes= strtotime('2020-10-30 10:10:20 + 20 minute');
//echo date('Y-m-d H:i:s', $addingFiveMinutes);
        
        $emp_time = date("Y-m-d H:i:s");
       $addingFiveMinutes= strtotime($emp_time);
        $emp_time = date('Y-m-d H:i:s', $addingFiveMinutes);
        $emp_lat =$_REQUEST['lat'];
        $emp_lon =$_REQUEST['lon'];
        $emp_geo =$_REQUEST['geo_location'];
        $remarks =$_REQUEST['remarks'];
        
        $time==$_REQUEST['time'];

        $query2 = "INSERT into `attendance_log` (emp_time, emp_id, org_category, workstation_id,emp_designation_id,emp_lat,emp_lon,emp_geo,remarks) VALUES ('$emp_time', $emp_id, $org_category, $workstation_id,$emp_designation_id,'$emp_lat','$emp_lon','$emp_geo','$remarks')";
        $result2 = mysqli_query($con,$query2);
        if($result2){
            echo "<div class='form'><h3>Your attendance recorded successfully.</h3><br/></div>";
        }
    }else{}
        ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                         <img class="mb-4" src="img/basmah.png" alt="basmah" width="100" height="60" align="center">
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <a href="logout.php" align="right">Logout</a>

                        <main class="form-signup" style="margin-left:20px;">
                                                 <form action="" method="post" name="frmAttendance">
                                                   
                                                    <h1 class="h3 mb-2 fw-normal">Basmah Attendance System</h1>

                                                    <div class="form-floating">
                                                        <label for="floatingInput">Name of the Department</label>
                                                        <input type="text" name="org_category" class="form-control" id="floatingInput" placeholder="" value="<?php echo $OrgCategory;?>" required readonly>
                                                      <input type="hidden" name="emp_id" value="<?php echo $empID; ?>" />
                                                       <input type="hidden" name="OrgCategoryID" value="<?php echo $OrgCategoryID; ?>" />
                                                        <input type="hidden" name="workstationID" value="<?php echo $workstationID; ?>" />
                                                         <input type="hidden" name="designationID" value="<?php echo $designationID; ?>" />
                                                    </div>

                                                     <div class="form-floating">
                                                        <label for="floatingInput">Workstation</label>
                                                        <input type="text" name="workstation" class="form-control" id="floatingInput" placeholder="" value="<?php echo $workstation;?>" required readonly>
                                                      
                                                    </div>

                                                    <div class="form-floating">
                                                        <label for="floatingInput">Name of the staff</label>
                                                        <input type="text" name="fullname" class="form-control" id="floatingInput" placeholder="" value="<?php echo $empName;?>" required readonly>
                                                      
                                                    </div>

                                                     <div class="form-floating">
                                                        <label for="floatingInput">Desgination</label>
                                                        <input type="text" name="designation" class="form-control" id="floatingInput" placeholder="" value="<?php echo $designation; ?>" required readonly>
                                                    </div>

                                                     <div class="form-floating">
                                                        <label for="floatingInput">Geo-cordinate</label>
                                                        
                                                          <button onclick="getLocation()">Geo-location</button>

                                                            <p id="demo"></p>

                                                            <input type="hidden" id="txtLat" name="lat" class="form-control" required>
                                                            <input type="hidden" id="txtLon" name="lon" class="form-control" required>
                                                            <input type="hidden" id="txtGeo" name="geo_location" class="form-control" required>

      
                                                             <iframe id="GeoLocation" width="100%" height="200" src="about:blank"></iframe>
 
<!--
                                                            <iframe src="'https://maps.google.com/maps?q=' + lat + ',' + lng + '&t=&z=15&ie=UTF8&iwloc=&output=embed'" />
 -->

                                                            <script>
                                                            const x = document.getElementById("demo");
                                                            
                                                            function getLocation() {
                                                              if (navigator.geolocation) {
                                                                navigator.geolocation.watchPosition(showPosition);
                                                              } else { 
                                                                x.innerHTML = "Geolocation is not supported by this browser.";
                                                              }
                                                            }
                                                                
                                                            function showPosition(position) {
                                                                 document.getElementById("txtGeo").value =  position.coords.latitude + " "+  position.coords.longitude;

                                                                 document.getElementById("txtLat").value =  position.coords.latitude;

                                                                 document.getElementById("txtLon").value =  position.coords.longitude;

                                                                 document.getElementById("GeoLocation").src = "https://maps.google.com/maps?q="+position.coords.latitude+","+position.coords.longitude+
                                                                 "&output=embed";

                                                                x.innerHTML="Latitude: " + position.coords.latitude + 
                                                                "<br>Longitude: " + position.coords.longitude;

                                                                 lat= position.coords.latitude;
                                                                 long = position.coords.longitude;


                                                            }
                                                            </script>  


                                                    </div>

                                                     <div class="form-floating">
                                                        <label for="floatingInput">Date & Time</label>
                                                        <!--
                                                        <input type="text" name="time" class="form-control" id="floatingInput" placeholder="<?php echo date('d-m-Y H:m:s');?>" value="<?php echo date('Y-m-d H:m:s');?>"required readonly>-->
                                                        
                                                          <?php $emp_time = date("Y-m-d H:i:s");
       $addingFiveMinutes= strtotime($emp_time);
        $emp_time = date('Y-m-d H:i:s', $addingFiveMinutes); ?>
                                                        <input type="text" name="time" class="form-control" id="floatingInput" placeholder="<?php echo $emp_time;?>" value="<?php echo $emp_time;?>"required readonly>
                                                    </div>

                                                        <div class="form-floating">
                                                        <label for="floatingInput">Remarks</label>
                                                        <input type="text" name="remarks" class="form-control" id="floatingInput" placeholder="">
                                                      </div>

                                                        <div class="form-floating">
                                                        
                                                        <input type="radio" name="check" class="form-check-input" placeholder="" required>  <label class="form-check-label" for="flexRadioDefault2">I confirm that to the best of my knowledge the information which I have provided above is correct and true.</label>
                                                      </div>

                                                     <button class="w-100 btn btn-lg btn-primary" type="submit">Save</button>
                                                   
                                                        <!--<input name="submit" type="submit" value="Login" />-->
                                                    
                                                   </form>
                                                    </main> 

                    </div>


                    <!-- Content Row -->
                    <div class="row">
                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; BASMAH <?php echo date('Y');?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>


</body>

</html>