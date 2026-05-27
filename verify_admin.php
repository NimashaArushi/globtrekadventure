<?php
session_start();
$conn = new mysqli("localhost", "root", "", "globetrek_db", 3308);

if (isset($_POST['login'])) {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

   
   $sql = "SELECT * FROM admins WHERE full_name = ? AND email = ? AND password = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $adminData = $result->fetch_assoc();
        
   
        $_SESSION['admin_access'] = true;
        $_SESSION['admin_name'] = $adminData['full_name'];
        
      
        header("Location: Administrator.php");
        exit();
    } else {
      
        header("Location: admin_login.php?error=invalid");
        exit();
    }
}
?>