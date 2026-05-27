<?php
session_start();

$conn = new mysqli("localhost", "root", "", "globetrek_db", 3308);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; 

if (isset($_POST['register'])) {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $staff_code = trim($_POST['staff_code']);

   
    $secret_key = "GT@2026"; 

    if ($staff_code !== $secret_key) {
        $message = "Invalid Staff Access Code! You are not authorized.";
    } else {
        $sql = "INSERT INTO admins (full_name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            $_SESSION['admin_access'] = true;
            $_SESSION['admin_name'] = $name;
            
            echo "<script>
                    alert('Verified & Registered Successfully!');
                    window.location.href='Administrator.php';
                  </script>";
        } else {
            $message = "Registration Failed: " . $conn->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - GlobeTrek</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
              
              background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                    url('travel10.jpg');
                    background-size: cover;
      background-size: cover;        
    background-position: center;  
    background-repeat: no-repeat; 
    

    min-height: 120vh; 
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
        }
        .reg-box { 
            background: white; 
            padding: 35px; 
            border-radius: 15px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            width: 350px; 
        }
        h2 { text-align: center; color: #333; margin-bottom: 25px; }
        
        input { 
            width: 100%; 
            padding: 12px; 
            margin: 10px 0; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            box-sizing: border-box; 
            font-size: 14px; 
        }
        
        button { 
            width: 100%; 
            padding: 12px; 
            background: #28a745; 
            color: white; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: bold;
            transition: 0.3s;
            margin-top: 10px;
        }
        
        button:hover { background: #218838; }
        
        .msg { 
            background: #f8d7da; 
            color: #721c24; 
            padding: 10px; 
            border-radius: 5px; 
            text-align: center; 
            font-size: 13px; 
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
        }
        
        .login-link { 
            text-align: center; 
            margin-top: 20px; 
            font-size: 14px; 
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        
        .login-link a { 
            color: #007bff; 
            text-decoration: none; 
            font-weight: bold; 
        }
        
        .login-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="reg-box">
        <h2>Register Admin</h2>
        
        <?php if($message != ""): ?>
            <div class="msg"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form action="" method="POST" autocomplete="off">
            <input type="text" name="full_name" placeholder="Full Name" required autocomplete="new-password">
            <input type="email" name="email" placeholder="Email Address" required autocomplete="new-password">
            <input type="password" name="password" placeholder="Create Password" required autocomplete="new-password">
            
            <input type="password" name="staff_code" placeholder="Staff Access Code" required>
            
            <button type="submit" name="register">Verify & Register</button>
        </form>

        <div class="login-link">
            <p>Already have an account? <a href="admin_login.php">Login Here</a></p>
        </div>
    </div>

</body>
</html>