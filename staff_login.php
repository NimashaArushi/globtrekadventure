<?php
session_start();
$conn = new mysqli("localhost", "root", "", "globetrek_db", 3308);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if (isset($_POST['login'])) {
   
    $email = isset($_POST['s_email']) ? trim($_POST['s_email']) : trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM staff WHERE email = ? AND password = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $staff = $result->fetch_assoc();
        
        $_SESSION['staff_logged_in'] = true;
       
        $_SESSION['staff_name'] = isset($staff['full_name']) ? $staff['full_name'] : $staff['name'];
        $_SESSION['staff_email'] = $email;
        $conn->query("UPDATE staff SET status = 'ACTIVE' WHERE email = '$email'");

        header("Location: Staff.php");
        exit();
    } else {
        $error = "Invalid Credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Login - GlobeTrek</title>
    <style>
        body {
             font-family: 'Poppins', sans-serif; 
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                    url('travel4.jpg');
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
             }
        input 
        { width: 100%;
         padding: 12px; 
         margin: 10px 0;
          border: 1px solid #ccc; 
          border-radius: 6px;
           box-sizing: border-box;
         }
        button {
             width: 100%; 
             padding: 12px; background: #34495e;
              color: white; 
              border: none; border-radius: 6px; cursor: pointer; 
              font-weight: bold; transition: 0.3s;
             }
        button:hover { 
            background: #2c3e50;
         }
        .error {
             color: red;
              text-align: center;
               font-size: 14px;
                background: #fee2e2;
                 padding: 8px;
                  border-radius: 4px; 
                  margin-bottom: 10px;
                 }
        .link { 
            text-align: center;
             margin-top: 15px; 
             font-size: 14px; 
            }
        a { 
            color: #34495e; 
            text-decoration: none; 
            font-weight: bold; 
        }
    </style>
</head>
<body>
    <div class="box">
        <h2>Staff Login</h2>
        
        <?php if($error != ""): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="" method="POST" autocomplete="off">
        <input type="email" name="s_email" placeholder="Email Address" required autocomplete="new-password">
            <input type="password" name="password" placeholder="Create Password" required autocomplete="new-password">
            <button type="submit" name="login">Staff Login</button>
        </form>

        <div class="link">
            <p>New Staff? <a href="staff_register.php">Register Here</a></p>
        </div>
    </div>
</body>
</html>