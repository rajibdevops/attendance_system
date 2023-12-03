<?php session_start();
if(!isset($_SESSION["username"])) { ?>

  <script>window.location = "https://srajib.info/basmah_attendance/login.php";</script>
  <?php }
?>
