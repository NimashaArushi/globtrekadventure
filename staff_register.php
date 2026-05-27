<?php
session_start();
$conn = new mysqli("localhost", "root", "", "globetrek_db", 3308);

$message = ""; 

if (isset($_POST['register'])) {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $staff_code = trim($_POST['staff_code']);

    $secret_key = "STAFF@GT"; 

    if ($staff_code !== $secret_key) {
        $message = "Invalid Secret Code! Contact Admin.";
    } else {
        $sql = "INSERT INTO staff (full_name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            $_SESSION['staff_logged_in'] = true;
            $_SESSION['staff_name'] = $name;
            echo "<script>alert('Staff Account Created!'); 
            window.location.href='staff.php';</script>";
            exit();
        } else {
            $message = "Error: Email already exists!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Registration - GlobeTrek</title>
    <style>
        body { font-family: 'Poppins', sans-serif; 
               background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                    url('travel.jpg');
                    background-size: cover;
      background-size: cover;       
    background-position: center;  
    background-repeat: no-repeat;  
    
    
    min-height: 120vh; 
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0; }
        .box {
             background: white;
              padding: 30px;
               border-radius: 12px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.1);
                 width: 350px;
                 }
        h2 {
             text-align: center; 
             color: #2c3e50; 
             margin-bottom: 20px; 
            }
        input {
             width: 100%;
              padding: 12px;
               margin: 10px 0;
                border: 1px solid #ccc;
                 border-radius: 6px;
                  box-sizing: border-box;
                 }
        button {
             width: 100%; 
             padding: 12px;
              background: #34495e; 
              color: white; 
              border: none; 
              border-radius: 6px; 
              cursor: pointer; 
              font-weight: bold;
               transition: 0.3s; 
               margin-top: 10px; 
            }
        button:hover {
             background: #2c3e50;
             }
        .msg { 
            color: #721c24; 
            background-color: #f8d7da; 
            border: 1px solid #f5c6cb;
             padding: 10px;
              border-radius: 6px; 
              text-align: center; 
              font-size: 13px; 
              margin-bottom: 15px;
             }
        .link { 
            text-align: center;
             margin-top: 15px;
              font-size: 14px; 
            }

        a { color: #34495e;
         text-decoration: none;
          font-weight: bold; 
        }
    </style>
</head>
<body>
    <div class="box">
        <h2>Staff Registration</h2>
        
        <?php if(!empty($message)): ?>
            <div class="msg"><?php echo $message; ?></div>
        <?php endif; ?>

      <form action="" method="POST" autocomplete="off">
           <input type="text" name="full_name" placeholder="Full Name" required autocomplete="off">

<input type="email" name="email" placeholder="Staff Email" required autocomplete="new-password">

<input type="password" name="password" placeholder="Password" required autocomplete="new-password">

<input type="password" name="staff_code" placeholder="Secret Staff Code" required autocomplete="new-password">
            <button type="submit" name="register">Register as Staff</button>
        </form>
        
        <div class="link">
            <a href="staff_login.php">Back to Staff Login</a>
        </div>
    </div>
</body>
</html>