<?php
/*
Author: Syed Rajib Rahman
Website: http://basmah.org/
*/
session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
	<title>:Basmah Attendance System:</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <!-- Bootstrap core CSS -->
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/signin.css" >
  </head>
<body>
<?php
	require('db.php');
    // If form submitted, insert values into the database.
    if (isset($_POST['username'])){
		$username = stripslashes($_REQUEST['username']); // removes backslashes
		$username = mysqli_real_escape_string($con,$username); //escapes special characters in a string
		$password = stripslashes($_REQUEST['password']);
		$password = mysqli_real_escape_string($con,$password);
		
	//Checking is user existing in the database or not
        $query = "SELECT * FROM `users` WHERE username='$username' and password='".md5($password)."'";
		$result = mysqli_query($con,$query) or die(mysqli_error($con));
		$rows = mysqli_num_rows($result);



        if($rows==1){
			$_SESSION['username'] = $username;
      //$_SESSION['user_type'] = $user_type;
      $rowUserType = mysqli_fetch_assoc($result);  
      $user_type=  $rowUserType["user_type"];
      $_SESSION['user_type'] = $user_type;

      if($user_type=='1')
        {?>
	  <script>window.location = "https://srajib.info/basmah_attendance/admin_index.php";</script>
      <?php } 
        else {?>
      <script>window.location = "https://srajib.info/basmah_attendance/index.php";</script>
     <?php }
			exit();
            }else{
				echo "<main class='form'><h3>Username/password is incorrect.</h3><br/>Click here to <a href='login.php'>Login</a></main>";
				}
    }else{
?>
<body class="text-center">
    
<main class="form-signin">
 <form action="" method="post" name="login">
    <img class="mb-4" src="img/basmah.png" alt="" width="100" height="60">
    <h1 class="h3 mb-2 fw-normal">Basmah Attendance System</h1>

    <div class="form-floating">
		<input type="text" name="username" class="form-control" id="floatingInput" placeholder="username" required>
      <label for="floatingInput">Username</label>
  	</div>

  	<div class="form-floating">
		<input type="password" name="password" class="form-control" id="floatingInput" placeholder="Password" required>
		<label for="floatingInput">Password</label>
	</div>
	 <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
   
		<!--<input name="submit" type="submit" value="Login" />-->
	</div>
   </form>

</main>
<?php

 } ?>

</body>
</html>