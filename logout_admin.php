<?php
session_start();
unset($_SESSION['admin_access']); 
header("Location: index.php"); 
exit();
?>