<?php
session_start(); 

session_unset();
session_destroy();
header("Location:login-patient.php");
exit;
?>
