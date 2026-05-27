<?php
session_start();
$conn = new mysqli("localhost", "root", "", "globetrek_db", 3308);
if (isset($_SESSION['staff_email'])) {
    $email = $_SESSION['staff_email'];
    $conn->query("UPDATE staff SET status = 'INACTIVE' WHERE email = '$email'");
}
session_unset();
session_destroy();
header("Location: index.php");
exit();
?>