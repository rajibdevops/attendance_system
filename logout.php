<?php
/*
Author: Syed Rajib Rahman
Website: http://basmah.org/
*/
session_start();
if(session_destroy()) // Destroying All Sessions
{
header("Location: login.php"); // Redirecting To Home Page
exit();
}
?>